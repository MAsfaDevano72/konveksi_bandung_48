<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\ProductionLog;
use App\Models\User;
use App\Models\ProductionOutput;
use App\Models\Employee; 
use Filament\Actions\Action;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; 
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Section;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class ProductionKanban extends KanbanBoard
{
    protected static string $model = Order::class;
    protected static string $recordTitleAttribute = 'product_name';
    protected static ?string $title = 'Tracking Produksi';
    protected static ?string $navigationLabel = 'Tracking Produksi';
    protected static ?string $navigationGroup = 'Produksi';
    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;
    public bool $searchable = true;
    public bool $disableEditModal = true; 
    
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ProductionStatsWidget::class,
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner', 'Tailor', 'Cutting', 'QC/Packing']);
    }

    public function getHeader(): View 
    {
        return view('filament.settings.custom-kanban-style');
    }

    protected function getActions(): array
    {
        return [
            $this->cicilHasilAction(),
            $this->viewOrderDetailsAction(),
            $this->startCuttingAction(),
            $this->finishCuttingAction(),
            $this->startStageAction(),
            $this->finishStageAction(),
        ];
    }

    protected function records(): Collection
    {
        $orders = Order::where('is_completed', false)->get();
        $kanbanRecords = collect();

        foreach ($orders as $order) {
            // 1. Tambahkan Kartu Asli (Untuk kolom Cutting atau Sewing)
            $kanbanRecords->push($order);

            // 2. Logika Kartu Bayangan (Shadow Card)
            if ($order->status === 'Sewing') {
                $totalJahit = $order->outputs()->where('stage', 'Sewing')->sum('qty') ?? 0;
                $totalQc = $order->outputs()->where('stage', 'QC/Packing')->sum('qty') ?? 0;

                if ($totalJahit > 0 && $totalQc < $order->quantity) {
                    
                    // Replicate membuat salinan objek Order yang sama persis
                    $shadow = $order->replicate(); 
                    
                    // KUNCI PENTING: Ubah ID & Status pada salinan ini
                    $shadow->id = (int) $order->id + 1000000; 
                    $shadow->status = 'QC/Packing'; 

                    $kanbanRecords->push($shadow);
                }
            }
        }

        return $kanbanRecords;
    }

    protected function statuses(): Collection
    {
        return collect([
            ['id' => 'Waiting', 'title' => '⏲️ Menunggu'],
            ['id' => 'Cutting', 'title' => '✂️ Potong'],
            ['id' => 'Sewing', 'title' => '🧵 Jahit'],
            ['id' => 'QC/Packing', 'title' => '📦 QC/Packing'],
            ['id' => 'Done', 'title' => '✅ Selesai'],
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('update_status')
                ->label('Update Status')
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('warning')
                ->visible(fn () => auth()->user()->hasRole(['Admin', 'Owner']))
                ->modalHeading('Update Status Produksi')
                ->form([
                    Forms\Components\Select::make('order_id')
                        ->label('Pilih SPK')
                        ->options(Order::where('status', '!=', 'Done')->pluck('order_number', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('stage')
                        ->label('Tahap Produksi')
                        ->options([
                            'Waiting' => 'Menunggu',
                            'Cutting' => 'Potong',
                            'Sewing' => 'Jahit',
                            'QC/Packing' => 'QC/Packing',
                            'Done' => 'Selesai',
                        ])->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'Mulai' => 'Mulai',
                            'Sedang Diproses' => 'Sedang Diproses',
                            'Selesai' => 'Selesai',
                        ])->required(),
                ])
                ->action(function (array $data) {
                    $order = Order::find($data['order_id']);
                    if ($order) {
                        $order->update(['status' => $data['stage']]);
                        
                        ProductionLog::create([
                            'order_id' => $order->id,
                            'employee_id' => Auth::user()->employee_id ?? 1,
                            'stage' => $data['stage'],
                            'status' => 'Selesai', // Asumsi manual update biasanya untuk menyelesaikan
                            'output_qty' => $data['output_qty'],
                            'reject_qty' => $data['reject_qty'],
                            'timestamp' => now(),
                        ]);

                        Notification::make()->title("Status Pesanan $order->order_number - $order->agency_name Diupdate manual ke $order->status")->success()->send();
                    }
                }),
        ];
    }

    private function getActiveHandler($recordId, $stage)
    {
        // Cari log yang statusnya 'Sedang Diproses' di tahap ini
        return \App\Models\ProductionLog::where('order_id', $recordId)
            ->where('stage', $stage)
            ->where('status', 'Sedang Diproses')
            ->with('employee') 
            ->first();
    }

    #[On('status-changed')]
    public function onStatusChanged(int|string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $lock = Cache::lock("kanban_move_order_{$recordId}", 10);

        if ($lock->get()) {
            try {
                $record = Order::find($recordId);
                $user = auth()->user();

                if ($record) {
                    // --- PROTEKSI TOTAL: HANYA ADMIN & OWNER ---
                    if (!$user->hasAnyRole(['Admin', 'Owner'])) {
                        Notification::make()
                            ->title('Akses Ditolak')
                            ->body("Hanya Admin atau Owner yang diperbolehkan memindahkan kartu secara manual.")
                            ->danger()
                            ->send();
                        
                        // Mengembalikan tampilan kartu ke posisi semula di UI
                        $this->dispatch('refreshKanban'); 
                        return; 
                    }

                    // Jika lolos proteksi (Admin/Owner), jalankan transaksi
                    DB::transaction(function () use ($record, $status, $user) {
                        \App\Models\ProductionLog::where('order_id', $record->id)
                            ->whereIn('status', ['Mulai', 'Sedang Diproses'])
                            ->delete(); 

                        $record->update(['status' => $status]);

                        \App\Models\ProductionLog::create([
                            'order_id'    => $record->id,
                            'employee_id' => $user->employee_id ?? 1,
                            'stage'       => $status,      
                            'status'      => 'Mulai',
                            'output_qty'  => 0,
                            'notes'       => 'Dipindahkan via Kanban oleh ' . $user->name,
                            'timestamp'   => now(),
                        ]);
                    });

                    Cache::forget('dashboard_stats_admin');
                    Cache::forget('dashboard_stats_general');
                    Cache::forget("order_tracking_{$record->id}");
                }
            } finally {
                $lock->release();
            }
        } else {
            Notification::make()
                ->title('Gagal Memindahkan')
                ->body('Pesanan ini sedang diproses oleh pengguna lain.')
                ->warning()
                ->send();
        }
    }

    // --- Action Button Logika ---

    // 1. Action Mulai Stage Jahit & QC/Packing
    public function startStageAction(): Action
    {
        return Action::make('startStage')
            ->label('Mulai Tahap Jahit')
            ->mountUsing(function ($form, array $arguments) {
                $recordId = $arguments['recordId'] ?? null;
                $realId = $recordId >= 1000000 ? ($recordId - 1000000) : $recordId;

                if ($form) {
                    $form->fill([
                        'record_id' => $recordId,
                        'employee_id' => auth()->user()->hasRole(['Tailor', 'QC/Packing']) ? auth()->user()->employee_id : null,
                    ]);
                }

            })
            ->form(function (array $arguments) {
                $recordId = $arguments['recordId'] ?? null;
                if (!$recordId) return [];

                $realId = $recordId >= 1000000 ? ($recordId - 1000000) : $recordId;
                if (!$recordId || (int)$recordId >= 1000000) {
                    return [];
                }
                
                $record = \App\Models\Order::find($realId);

                if (!$record || $record->status === 'QC/Packing') {
                    return [];
                }

                if (!auth()->user()->hasAnyRole(['Admin', 'Owner']) || $record->status !== 'Sewing') {
                    return [];
                }

                return [
                    Forms\Components\Select::make('employee_id')
                        ->label('Pilih Penjahit')
                        ->options(function() {
                            return \App\Models\Employee::where('status', 'active')
                                ->where('job_desk', 'Tailor') 
                                ->pluck('name', 'id');
                        })
                        ->required()
                        ->placeholder('Pilih penjahit yang bertugas...')
                        ->helperText("Khusus tahap Jahit, Admin harus memilihkan penjahitnya."),
                ];
            })
            ->action(function (array $data, array $arguments) {
                $recordId = $arguments['recordId'] ?? null;
                $realId = $recordId >= 1000000 ? ($recordId - 1000000) : $recordId;
                $record = \App\Models\Order::find($realId);

                if (!$record) return;

                $assignedEmployeeId = $data['employee_id'] ?? auth()->user()->employee_id;

                if (!$assignedEmployeeId) {
                    \Filament\Notifications\Notification::make()
                        ->title('Gagal')
                        ->body("Petugas belum ditentukan.")
                        ->danger()
                        ->send();
                    return;
                }

                \App\Models\ProductionLog::create([
                    'order_id' => $record->id,
                    'employee_id' => $assignedEmployeeId,
                    'stage' => $record->status,
                    'status' => 'Sedang Diproses',
                    'output_qty' => 0,
                    'timestamp' => now(),
                ]);

                \Filament\Notifications\Notification::make()
                    ->title("Jahit untuk pesanan $record->order_number Dimulai")
                    ->body("Dijahit oleh ". Employee::find($assignedEmployeeId)?->name)
                    ->success()
                    ->send();
            });
    }

    // 2. Action Selesai Normal (Jahit & QC/Packking)
    public function finishStageAction(): Action
    {
        return Action::make('finishStage')
            ->record(fn (array $arguments) => Order::find($arguments['recordId'] ?? $arguments['record']))
            ->mountUsing(fn (Forms\ComponentContainer $form, array $arguments) => $form->fill([
                'record_id' => $arguments['recordId'] ?? $arguments['record'] ?? null,
            ]))
            ->label("Input Hasil Tahap ini")
            ->form([
                Forms\Components\Hidden::make('record_id'),
                Forms\Components\Placeholder::make('info')
                    ->label('Instruksi')
                    ->content('Masukkan hasil akhir untuk tahap ini.'),
                Section::make('Informasi Pesanan')
                    ->schema([
                        Forms\Components\Placeholder::make('info_spk')
                            ->label('Kode SPK')
                            ->content(fn ($record) => $record?->order_number), // Sesuaikan nama kolom

                        Forms\Components\Placeholder::make('info_agency')
                            ->label('Instansi / Pemesan')
                            ->content(fn ($record) => $record?->agency_name . ' ( ' . $record?->client_name . ' )'),

                        Forms\Components\Placeholder::make('info_target')
                            ->label('Target Pesanan')
                            ->content(fn ($record) => new HtmlString('<span class="font-bold text-primary-600 text-lg">' . $record?->quantity . ' Pcs</span>')),
                        
                        Forms\Components\Placeholder::make('current_stage')
                            ->label('Tahap Saat Ini')
                            ->content(fn ($record) => new HtmlString('<span class="font-bold text-sm border p-2 text-primary-600 bg-gray-100 rounded-lg">' . $record?->status . '</span>')),
                    ])
                    ->columns(2)
                    ->compact(),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('output_qty')
                        ->label('Jumlah Berhasil (Pcs)')
                        ->numeric()
                        ->required()
                        ->maxValue(fn ($record) => $record->quantity)
                        ->suffix(fn ($record) => " / " . $record->quantity . " Pcs"),
                    Forms\Components\TextInput::make('reject_qty')
                        ->label('Jumlah Reject (Pcs)')
                        ->numeric()
                        ->default(0)
                        ->helperText('Akan terisi otomatis jika hasil kurang dari target.'),
                ]),
                Forms\Components\Textarea::make('notes')->label('Catatan (Opsional)'),
            ])
            
            ->action(function (array $data, Order $record) {
                if (!$record) return;

                //Reject otomatis terisi jika input hasil kurang dari target
                $target = $record->quantity;
                $success = (int) $data['output_qty'];
                $calculatedReject = ($success < $target) ? ($target - $success) : (int)$data['reject_qty'];

                $currentStatus = $record->status;
                $nextStatus = match($currentStatus) {
                    'Cutting' => 'Sewing',
                    'Sewing' => 'QC/Packing',
                    'QC/Packing' => 'Done',
                    default => 'Done'
                };

                // 1. Update Log Tahap Sekarang
                $lastLog = \App\Models\ProductionLog::where('order_id', $record->id)
                ->where('stage', $currentStatus)
                ->whereIn('status', ['Sedang Diproses', 'Mulai'])
                ->latest()
                ->first();

                if ($lastLog) {
                    $lastLog->update([
                        'status' => 'Selesai',
                        'output_qty' => $success,
                        'reject_qty' => $calculatedReject, 
                        'notes' => $data['notes'],
                        'timestamp' => now(),
                    ]);
                }

                // 2. CEK AGAR TIDAK DOUBLE LOG UNTUK TAHAP BERIKUTNYA
                if ($nextStatus !== 'Done') {
                    \App\Models\ProductionLog::updateOrCreate(
                        [
                            'order_id' => $record->id,
                            'stage' => $nextStatus,
                            'status' => 'Mulai',
                        ],
                        [
                            'employee_id' => Auth::user()->employee_id ?? 1,
                            'timestamp' => now(),
                        ]
                    );
                }

                // 3. Update Status Order Utama
                $record->update(['status' => $nextStatus]);
                $recipients = Cache::remember('users_with_production_roles', 3600, function () {
                    return User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();
                });

                Notification::make()
                ->title("Pesanan $record->order_number - $record->agency_name pada Tahap $currentStatus Berhasil Diselesaikan")
                ->success()
                ->sendToDatabase($recipients)
                ->send();
            });
    }

    // 3. Action Konfirmasi ke Cutting
    public function confirmToCutting($recordId): void
    {
        $record = Order::find($recordId);
        if ($record) {
            $record->update(['status' => 'Cutting']);
            
            \App\Models\ProductionLog::create([
                'order_id' => $record->id,
                'employee_id' => Auth::user()->employee_id ?? 1,
                'stage' => 'Waiting',
                'status' => 'Selesai', 
                'timestamp' => now(),
            ]);

            $recipients = Cache::remember('users_with_production_roles', 3600, function () {
                    return User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();
                });
            Notification::make()
                ->title("Pesanan $record->order_number dipindahkan ke Tahap Potong") // Sedikit dipersingkat agar rapi
                ->success()
                ->sendToDatabase($recipients)
                ->send();
        }
    }

    // 4. Action Mulai Cutting (Pilih Bahan & Kurangi Stok)
    public function startCuttingAction(): Action
    {
        return Action::make('startCutting')
            ->mountUsing(function (Forms\ComponentContainer $form, array $arguments) {
                $record = Order::find($arguments['recordId']);
                $modelBajuDefault = $record->is_stock_production 
                ? trim(explode('(', $record->product_name)[0]) 
                : '';
                $form->fill([
                    'record_id' => $arguments['recordId'],
                    'order_number' => $record?->order_number,
                    'agency_name' => $record?->agency_name,
                    'client_name' => $record?->client_name,
                    'total_target' => $record?->quantity,
                    'model_baju' => $modelBajuDefault,
                ]);
            })
            ->label("Input Bahan & Mulai Cutting")
            ->form([
                Forms\Components\Hidden::make('record_id'),
                Forms\Components\Section::make('Detail Pesanan')
                ->compact()
                ->columns(3)
                ->schema(function ($get) {
                    $record = Order::find($get('record_id'));
                    $isFastTrack = $record?->is_stock_production;

                    return [
                        Forms\Components\Placeholder::make('order_number')
                            ->label('No. Order :')
                            ->content(fn ($get) => $get('order_number')),
                        Forms\Components\Placeholder::make('agency_name')
                            ->label('Nama Instansi : ')
                            ->content(fn ($get) => $get('agency_name')),
                        Forms\Components\Placeholder::make('client_info')
                            ->label($isFastTrack ? 'Detail Warna:' : 'Atas Nama:')
                            ->content($isFastTrack ? "WARNA " . $get('client_name') : $get('client_name')),
                        ];
                    }),

                Forms\Components\Section::make('Pemakaian Bahan Baku')
                    ->description("Pilih kain dan tentukan model baju.")
                    ->columns(3)
                    ->schema(function ($get) {
                        $record = Order::find($get('record_id'));
                        
                        if ($record && $record->is_stock_production) {
                            $inv = \App\Models\Inventory::find($record->inventory_id);
                            $jmlRolFT = $record->qty_roll ?? 0;
                            $jmlYardFT = $record->used_yard ?? 0;

                            return [
                                Forms\Components\TextInput::make('model_baju')
                                    ->label('Model Baju / Artikel')
                                    ->default(explode('(', $record->product_name)[0] ?? '-') 
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Placeholder::make('info_bahan')
                                ->label('Bahan Baku (Gudang)')
                                ->content(function() use ($inv, $jmlRolFT, $jmlYardFT) {
                                    if (!$inv) return '-';
                                    return "Kain: {$inv->name} | Warna: {$inv->color} | Spesifikasi: {$jmlRolFT} Rol {$jmlYardFT} Yard";
                                })
                                ->columnSpanFull(),
                                Forms\Components\Hidden::make('inventory_id')->default($record->inventory_id),
                                Forms\Components\Hidden::make('qty_roll')->default($jmlRolFT), 
                                Forms\Components\Hidden::make('used_yard')->default($jmlYardFT), 
                            ];
                        }

                        // LOGIKA PESANAN BIASA (REGULER)
                        return [
                            Forms\Components\TextInput::make('model_baju')
                                ->label('Model Baju')
                                ->placeholder('Contoh: Kaftan Silk, Kebaya Modern, dll')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Select::make('inventory_id')
                                ->label('Pilih Kain')
                                ->options(fn() => \App\Models\Inventory::where('type', 'Kain')
                                        ->where('stock', '>', 0)
                                        ->get()
                                        ->mapWithKeys(function ($item) {
                                            return [$item->id => "{$item->name} - {$item->color}  || Sisa: {$item->stock} Rol ({$item->length} Yard)"];
                                        }
                                ))
                                ->columnSpanFull()
                                ->reactive()
                                ->required(),

                            Forms\Components\TextInput::make('qty_roll')
                                ->label('Jumlah Rol Digunakan')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->minValue(1),

                            Forms\Components\TextInput::make('used_yard')
                                ->label('Total Yard Digunakan')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->minValue(1)
                                ->helperText('Masukkan total yard yang dipotong dari roll tersebut'),
                            
                            Forms\Components\Placeholder::make('summary_bahan')
                                ->label('Ringkasan Instruksi Bahan:')
                                ->columnSpanFull()
                                ->content(function($get) {
                                    $inv = \App\Models\Inventory::find($get('inventory_id'));
                                    if(!$get('model_baju') || !$inv) return "Silahkan isi model dan pilih kain...";
                                    
                                    $qty = $get('qty_roll') ?? 0;
                                    $yard = $get('used_yard') ?? 0;
                                    
                                    return "Model Baju: {$get('model_baju')} | Kain: {$inv->name} | Warna: {$inv->color} | Rol: {$qty} Rol {$yard} Yard";
                                }),
                        ];
                    }),
            ])
            ->action(function (array $data) {
                $record = Order::find($data['record_id']);
                $inventoryId = $data['inventory_id'] ?? $record?->inventory_id;

                if (!$inventoryId) {
                    Notification::make()->title('ID Bahan tidak ditemukan di sistem')->danger()->send();
                    return;
                }

                $lock = Cache::lock("processing_inventory_{$inventoryId}", 10);

                if ($lock->get()) {
                    try {
                        return DB::transaction(function () use ($data, $inventoryId, $record) {
                            $inventory = \App\Models\Inventory::find($inventoryId);

                            if (!$inventory) {
                                Notification::make()->title('Data Kain tidak ditemukan di Database')->danger()->send(); 
                                return;
                            }

                            // --- 1. KALKULASI DATA ---
                            $jmlRol = $record->is_stock_production ? ($record->qty_roll ?? 0) : ($data['qty_roll'] ?? 0);
                            $jmlYard = $record->is_stock_production ? ($record->used_yard ?? 0) : ($data['used_yard'] ?? 0);
                            $modelBaju = $data['model_baju'] ?? '-';

                            // --- 2. UPDATE DATA PRODUK & STOK ---
                            if ($record->is_stock_production) {
                                $record->update([
                                    'product_name' => $modelBaju . " (" . $inventory->name . ")",
                                ]);
                                
                                $logNotes = "FAST TRACK - Model: {$modelBaju} | Kain: {$inventory->name} | Warna: {$inventory->color} | Rol: {$jmlRol} Rol {$jmlYard} Yard";
                            } else {
                                if ($jmlRol > $inventory->stock || $jmlYard > $inventory->length) {
                                    Notification::make()->title('Stok atau Yard Tidak Cukup!')->danger()->send(); 
                                    return;
                                }

                                $record->update([
                                    'inventory_id' => $inventoryId,
                                    'qty_roll'     => $jmlRol,
                                    'used_yard'    => $jmlYard,
                                ]);

                                if ($jmlRol > 0) {
                                    $inventory->decrement('stock', $jmlRol);
                                    $inventory->decrement('length', $jmlYard);
                                    
                                    \App\Models\InventoryHistory::create([
                                        'inventory_id' => $inventory->id,
                                        'type' => 'Terpakai',
                                        'quantity' => $jmlRol,
                                        'notes' => "Produksi SPK: {$record->order_number} (Terpakai {$jmlYard} Yard)",
                                    ]);
                                }

                                $logNotes = "Model: {$modelBaju} | Kain: {$inventory->name} | Warna: {$inventory->color} | Rol: {$jmlRol} Rol {$jmlYard} Yard";
                            }

                            // --- 3. PEMBUATAN PRODUCTION LOG ---
                            \App\Models\ProductionLog::create([
                                'order_id' => $record->id,
                                'employee_id' => auth()->user()->employee_id ?? 1,
                                'stage' => 'Cutting',
                                'status' => 'Sedang Diproses',
                                'notes' => $logNotes,
                                'timestamp' => now(),
                            ]);

                            Cache::forget('dashboard_stats_admin');
                            
                            Notification::make()
                                ->title("Cutting untuk pesanan $record->order_number Dimulai")
                                ->success()
                                ->send();
                        });
                    } finally {
                        $lock->release();
                    }
                }
            });
    }

    // 5. Action Selesai Cutting (Input Size - FLEKSIBEL)
    public function finishCuttingAction(): Action
    {
        return Action::make('finishCutting')
            ->mountUsing(function (Forms\ComponentContainer $form, array $arguments) {
                $record_id = $arguments['recordId'] ?? $arguments['record'] ?? null;
                $record = Order::find($record_id);
                $templateSizes = [
                    ['size' => 'S',   'qty' => 0],
                    ['size' => 'M',   'qty' => 0],
                    ['size' => 'L',   'qty' => 0],
                    ['size' => 'XL',  'qty' => 0],
                ];

                $form->fill([
                    'record_id' => $record_id,
                    'order_number' => $record?->order_number,
                    'client_name' => $record?->client_name,
                    'agency_name' => $record?->agency_name,
                    'total_target' => $record?->quantity,
                    'sizes' => $templateSizes,  
                ]);
            })
            ->label("Selesai Cutting")
            ->form([
                Forms\Components\Hidden::make('record_id'),
                Forms\Components\Section::make('Informasi Produksi')
                    ->compact()
                    ->columns(4)
                    ->schema([
                        Forms\Components\Placeholder::make('order_number')
                            ->label('Nomor SPK :')
                            ->content(fn ($get) => $get('order_number')),
                        Forms\Components\Placeholder::make('agency_name')
                            ->label('Nama Instansi :')
                            ->content(fn ($get) => $get('agency_name')),
                        Forms\Components\Placeholder::make('client_name')
                            ->label(function ($get) {
                                    $record = \App\Models\Order::find($get('record_id'));
                                    return ($record && $record->is_stock_production) ? 'Warna :' : 'Atas Nama :';
                                })
                            ->content(fn ($get) => $get('client_name')),
                        Forms\Components\Placeholder::make('total_target')
                            ->label('Target Keseluruhan :')
                            // Tampilan dinamis: Jika 0 berarti "Belum ditentukan"
                            ->content(fn ($get) => new \Illuminate\Support\HtmlString(
                                $get('total_target') == 0 
                                ? "<strong class='text-emerald-600'>FLEKSIBEL (Ikuti Hasil Potong)</strong>" 
                                : "<strong>{$get('total_target')} Pcs</strong>"
                            )),
                    ]),
                Forms\Components\Repeater::make('sizes')
                    ->label('Input Hasil Potongan Per Size')
                    ->schema([
                        Forms\Components\Select::make('size')
                            ->options(['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', 'XXL' => 'XXL'])
                            ->required(), 
                        Forms\Components\TextInput::make('qty')
                            ->label('Jumlah (Pcs)')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->rules([
                                fn (Forms\Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $totalInput = collect($get('../../sizes'))->sum('qty');
                                    $target = (int) $get('../../total_target');
                                    
                                    // VALIDASI: Hanya jalankan jika target > 0 (Pesanan Biasa)
                                    if ($target > 0 && $totalInput > $target) {
                                        $fail("Total hasil potong ({$totalInput}) tidak boleh melebihi target ({$target} Pcs).");
                                    }
                                },
                            ]),
                    ])
                    ->columns(2)
                    ->addable(true) 
                    ->deletable(true) 
                    ->reorderable(false),
            ])
            ->action(function (array $data) {
                $record = Order::find($data['record_id']);
                if (!$record) return;
                
                $validSizes = collect($data['sizes'])
                    ->filter(fn($item) => $item['qty'] > 0)
                    ->values()
                    ->toArray();

                $totalOutput = collect($validSizes)->sum('qty');

                if ($record->quantity == 0) {
                    $record->update(['quantity' => $totalOutput]);
                }

                $log = ProductionLog::where('order_id', $record->id)
                    ->where('stage', 'Cutting')
                    ->where('status', 'Sedang Diproses')
                    ->first();

                if ($log) {
                    $log->update([
                        'status' => 'Selesai',
                        'output_qty' => $totalOutput,
                        'notes' => $log->notes . " | SIZES_DATA:" . json_encode($validSizes),
                    ]);
                }

                $record->update(['status' => 'Sewing']);

                ProductionLog::create([
                    'order_id' => $record->id,
                    'employee_id' => Auth::user()->employee_id ?? 1,
                    'stage' => 'Sewing',
                    'status' => 'Mulai',
                    'timestamp' => now(),
                ]);

                $recipients = Cache::remember('users_with_production_roles', 3600, function () {
                    return User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();
                });

                Notification::make()
                    ->title("Proses Cutting pesanan $record->order_number ( $record->agency_name ) Selesai, Lanjut ke Penjahitan")
                    ->success()
                    ->sendToDatabase($recipients)
                    ->send();
            });
    }

    // 6. Action Selesai Total atau Repeat Order
    public function selesaiTotalAction(): Action
    {
        return Action::make('selesaiTotalAction') 
            ->label('Selesaikan Pesanan / Repeat Order')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->form(function (array $arguments) {
                $record = Order::find($arguments['recordId'] ?? null);
                
                // Jika kartu adalah Fast Track, jangan tampilkan form (langsung eksekusi di action)
                if ($record && $record->is_stock_production) {
                    return [];
                }

                // Jika pesanan biasa, tampilkan pilihan seperti biasa
                return [
                    Forms\Components\Hidden::make('record_id')
                        ->default($arguments['recordId'] ?? null), 
                    Radio::make('keputusan_akhir')
                        ->label('Tindak Lanjut Pesanan')
                        ->options([
                            'finish' => 'Selesai & Arsipkan (Hilangkan dari Board)',
                            'repeat' => 'Ulangi Pesanan (Repeat Order)',
                        ])
                        ->descriptions([
                            'finish' => 'Pesanan selesai sepenuhnya. Data tetap ada di menu Pesanan & SPK.',
                            'repeat' => 'Kembalikan ke status awal (Menunggu) untuk produksi ulang.',
                        ])
                        ->default('finish')
                        ->required(),
                ];
            })
            ->action(function (array $data, array $arguments) {
                $recordId = $data['record_id'] ?? $arguments['recordId'] ?? null;
                $record = Order::find($recordId);
                $recipients = User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();

                if (!$record) {
                    Notification::make()->title('Data tidak ditemukan')->danger()->send();
                    return;
                }

                // Logika: Jika Fast Track ATAU memilih 'finish'
                if ($record->is_stock_production || ($data['keputusan_akhir'] ?? 'finish') === 'finish') {
                    
                    $record->update([
                        'is_completed' => true,
                    ]);

                    Notification::make()
                        ->title("Pesanan $record->order_number Berhasil Diarsipkan")
                        ->body($record->is_stock_production ? 'Kartu Fast Track otomatis selesai.' : 'Kartu pesanan telah diarsipkan.')
                        ->success()
                        ->sendToDatabase($recipients)
                        ->send();

                } else {
                    // Logika Repeat Order (Hanya untuk pesanan non-stock)
                    ProductionLog::where('order_id', $record->id)->delete();
                    ProductionOutput::where('order_id', $record->id)->delete();
                    
                    $record->update([
                        'status' => 'Waiting', 
                        'is_completed' => false,
                        'notes' => null, 
                        'qty_roll' => 0, 
                        'quantity' => 0,
                    ]);

                    ProductionLog::create([
                        'order_id' => $record->id,
                        'employee_id' => Auth::user()->employee_id ?? 1,
                        'stage' => 'Waiting',
                        'status' => 'Mulai',
                        'notes' => 'Pesanan diulang (Repeat Order).',
                        'timestamp' => now(),
                    ]); 

                    Notification::make()
                        ->title("Pesanan $record->order_number Diulang")
                        ->info()
                        ->sendToDatabase($recipients)
                        ->send();
                }
            });
    }

    // 7. Action Lihat Detail Pesanan & Produksi
    public function viewOrderDetailsAction(): Action
    {
        return Action::make('viewOrderDetails')
            ->label('Detail Pesanan')
            ->modalHeading('Informasi Detail Pesanan & Produksi')
            ->modalWidth('2xl')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup')
            ->record(function (array $arguments) {
                $id = $arguments['recordId'] ?? $arguments['record'] ?? null;
                if (!$id) return null;

                $realId = $id >= 1000000 ? ($id - 1000000) : $id;
                return \App\Models\Order::find($realId);

                $isFastTrack = $realId?->is_stock_production;
            })
            ->infolist(function ( $infolist ,?Order $record): Infolist {
                if (!$record) {
                    return $infolist->schema([
                        Infolists\Components\TextEntry::make('error')
                            ->label('')
                            ->default('Data tidak dapat dimuat. Silakan refresh halaman.')
                    ]);
                }
                return $infolist
                    ->record($record)
                    ->schema([
                        // --- BAGIAN 1: IDENTITAS PESANAN ---
                        Infolists\Components\Section::make('Identitas Pesanan')
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('order_number')
                                    ->label('Kode SPK :')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->copyable()
                                    ->placeholder('Data tidak ditemukan'),
                                Infolists\Components\TextEntry::make('product_name')
                                    ->label(fn ($record) => $record?->is_stock_production ? 'Model Baju ( Kain ) :' : 'Nama Produk :'),
                                Infolists\Components\TextEntry::make('agency_name')
                                    ->label(fn ($record) => $record?->is_stock_production ? 'Produksi langsung dari :' : 'Nama Instansi :'),
                                Infolists\Components\TextEntry::make('client_name')
                                    ->label(fn ($record) => $record?->is_stock_production ? 'Warna :' : 'Nama Pemesan :'),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Nomor HP :')
                                    ->icon('heroicon-m-phone')
                                    ->copyable()
                                    ->suffixAction(
                                        Infolists\Components\Actions\Action::make('chatWA')
                                            ->label('Hubungi')
                                            ->icon('heroicon-m-chat-bubble-left-right')
                                            ->url(fn() => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->customer_phone))
                                            ->openUrlInNewTab()
                                    ),
                                Infolists\Components\TextEntry::make('deadline')
                                    ->label(fn ($record) => $record?->is_stock_production ? '' : 'Tanggal Deadline :')
                                    ->date('d F Y')
                                    ->color('danger')
                                    ->weight('bold'),
                            ]),

                        // --- BAGIAN 2: INFO BAHAN & PRODUKSI ---
                        Infolists\Components\Section::make('Informasi Bahan & Produksi')
                            ->schema([
                                Infolists\Components\Grid::make(3)->schema([
                                    Infolists\Components\TextEntry::make('status')
                                        ->label('Tahap Saat Ini')
                                        ->badge()
                                        ->color('warning'),
                                    Infolists\Components\TextEntry::make('quantity')
                                        ->label('Target Pesanan')
                                        ->suffix(' Pcs')
                                        ->weight('bold'),
                                    Infolists\Components\TextEntry::make('created_at')
                                        ->label('Tgl Masuk Order')
                                        ->date('d/m/Y'),
                                ]),
                                Infolists\Components\TextEntry::make('bahan_model')
                                    ->label('Bahan & Model Baju')
                                    ->placeholder('Data bahan belum tersedia.')
                                    ->state(function ($record) {
                                        $log = $record->productionLogs()
                                            ->where('notes', 'like', '%Model:%')
                                            ->first();
                                        if (!$log) return null;
                                        return str($log->notes)->before(' | SIZES_DATA:');
                                    })
                                    ->columnSpanFull(),

                                Infolists\Components\TextEntry::make('size_details')
                                    ->label('Detail Hasil Potongan (Size)')
                                    ->placeholder('Detail potongan belum tersedia.')
                                    ->html()
                                    ->state(function ($record) {
                                        $log = $record->productionLogs()
                                            ->where('notes', 'like', '%SIZES_DATA:%')
                                            ->first();
                                        if (!$log) return null;
                                        $jsonString = str($log->notes)->after('SIZES_DATA:');
                                        $details = json_decode($jsonString, true);
                                        if (is_array($details)) {
                                            return collect($details)->map(function ($item) {
                                                return "<span style='display:inline-block; background:#eff6ff; color:#1e40af; padding:2px 8px; border-radius:4px; font-weight:bold; margin-right:5px; border:1px solid #bfdbfe;'>Size {$item['size']}: {$item['qty']} Pcs</span>";
                                            })->implode(' ');
                                        }
                                        return null;
                                    })
                                    ->columnSpanFull(),
                            ]),

                        // --- BAGIAN 3: KONTRIBUTOR PRODUKSI (OUTPUT CICILAN) ---
                        Infolists\Components\Section::make('Capaian Penjahit & QC')
                            ->description('Daftar pegawai yang menyetor hasil produksi')
                            ->collapsible()
                            ->schema([
                                Infolists\Components\TextEntry::make('production_outputs')
                                    ->label('')
                                    ->html()
                                    ->state(function ($record) {
                                        $outputs = $record->outputs()
                                            ->with('employee')
                                            ->selectRaw('employee_id, stage, sum(qty) as total_qty')
                                            ->groupBy('employee_id', 'stage')
                                            ->get();

                                        if ($outputs->isEmpty()) {
                                            return '<div class="text-sm text-gray-500 italic">Belum ada setoran hasil produksi.</div>';
                                        }

                                        $html = '<table class="w-full text-sm text-left border-collapse">';
                                        $html .= '<thead class="bg-gray-50 text-gray-700 uppercase text-[10px] font-bold">';
                                        $html .= '<tr><th class="px-4 py-2 border">Pegawai</th><th class="px-4 py-2 border">Bagian</th><th class="px-4 py-2 border text-right">Total Hasil</th></tr></thead>';
                                        $html .= '<tbody class="divide-y">';

                                        foreach ($outputs as $output) {
                                            $realName = DB::table('employees')->where('id', $output->employee_id)->value('name');

                                            $html .= '<tr>';
                                            $html .= '<td class="px-4 py-2 border">' . ($realName ?? Auth::user()->name) . '</td>';
                                            $html .= '<td class="px-4 py-2 border"><span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 dark:text-gray-100 rounded text-[10px]">' . $output->stage . '</span></td>';
                                            $html .= '<td class="px-4 py-2 border text-right font-bold text-primary-600">' . $output->total_qty . ' Pcs</td>';
                                            $html .= '</tr>';
                                        }

                                        $html .= '</tbody></table>';
                                        return $html;
                                    })
                                    ->columnSpanFull(),
                            ]),

                        // --- BAGIAN 4: RIWAYAT LOG (CATATAN SISTEM) ---
                        Infolists\Components\Section::make('Riwayat Log Sistem')
                            ->collapsible()
                            ->collapsed() 
                            ->schema([
                                Infolists\Components\ViewEntry::make('productionLogs')
                                    ->label('')
                                    ->view('filament.components.log-history-table')
                                    ->state(fn($record) => $record?->productionLogs()->with('user')->orderBy('timestamp', 'desc')->get() ?? collect([])),
                            ])
                    ]);
            });
    }

    // 8. Action Setor Hasil (Cicil Jahit & QC)
    public function cicilHasilAction(): Action
    {
        return Action::make('cicilHasil')
            ->label('Cicil Hasil')
            ->color('success')
            ->icon('heroicon-m-check-badge')
            ->modalWidth('xl')
            ->modalHeading('Input Setoran Hasil Produksi')
            ->record(fn (array $arguments) => \App\Models\Order::find(
                ((int)($arguments['recordId'] ?? 0) >= 1000000) 
                ? ((int)$arguments['recordId'] - 1000000) 
                : (int)($arguments['recordId'] ?? 0)
            ))
            ->mountUsing(function (Forms\ComponentContainer $form, array $arguments) {
                $idVal = (int) ($arguments['recordId'] ?? 0);
                $realId = $idVal >=1000000 ? ($idVal - 1000000) : $idVal;

                $record = \App\Models\Order::find($realId);
                if ($record) {
                    $form->model($record)->fill();
                }
            })
            ->form(function (array $arguments) { 
                $idVal = (int) ($arguments['recordId'] ?? 0);
                $realId = $idVal >=1000000 ? ($idVal - 1000000) : $idVal;

                $record = \App\Models\Order::find($realId);
                
                if (!$record) {
                    return [
                        Forms\Components\Placeholder::make('loading')
                            ->content('Data tidak ditemukan (ID: ' . $idVal . ')')
                    ];
                }

                $isQcColumn = $idVal >= 1000000 || $record->status === 'QC/Packing';
                $currentStage = $isQcColumn ? 'QC/Packing' : $record->status;

                $totalSelesaiTahapIni = $record->outputs()->where('stage', $currentStage)->sum('qty') ?? 0;
                $totalDariJahit = $record->outputs()->where('stage', 'Sewing')->sum('qty') ?? 0;

                if ($isQcColumn) {
                    // VALIDASI QC: Maksimal adalah apa yang sudah dijahit dikurangi yang sudah di-QC
                    $sisa = max(0, $totalDariJahit - $totalSelesaiTahapIni);
                    $infoStatus = new \Illuminate\Support\HtmlString("<span class='text-primary-600 font-bold text-lg'>{$totalDariJahit} Pcs</span> <span class='text-gray-400'>(Tersedia dari Jahit)</span>");
                } else {
                    // VALIDASI JAHIT: Maksimal adalah Target Order
                    $sisa = max(0, $record->quantity - $totalSelesaiTahapIni);
                    $infoStatus = new \Illuminate\Support\HtmlString("<span class='text-warning-600 font-bold text-lg'>{$record->quantity} Pcs</span> <span class='text-gray-400'>(Target Order)</span>");
                }

                return [
                    Forms\Components\Section::make('Informasi Pesanan (' . $currentStage . ')')
                    ->compact()
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Placeholder::make('spk')
                                    ->label('Nomor SPK :')
                                    ->content(new \Illuminate\Support\HtmlString("<span class='text-warning-600 font-mono font-bold'>{$record->order_number}</span>")),
                                Forms\Components\Placeholder::make('instansi')
                                    ->label('Pelanggan :')
                                    ->content($record->agency_name),
                                Forms\Components\Placeholder::make('produk')
                                    ->label('Produk :')
                                    ->content(new \Illuminate\Support\HtmlString("<span class='font-medium'>{$record->product_name}</span>")),
                            ]),
                    ]),

                    Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Placeholder::make('info_limit')
                            ->label($isQcColumn ? 'Barang tersedia untuk QC' : 'Target Total Pesanan')
                            ->content($infoStatus),
                        Forms\Components\Placeholder::make('target')
                            ->label('Sudah di-' . ($isQcColumn ? 'QC & Packing' : 'Jahit'))
                            ->content(new \Illuminate\Support\HtmlString(
                                "<div class='flex items-center gap-2'>
                                    <span class='text-success-600 font-bold text-lg'>{$totalSelesaiTahapIni}</span>
                                    <span class='text-gray-400'>/ {$record->quantity} Pcs Selesai</span>
                                </div>"
                            )),
                    ]),

                    Forms\Components\TextInput::make('qty_input')
                        ->label('Jumlah yang Diserahkan Saat Ini')
                        ->numeric()
                        ->required()
                        ->helperText('Sudah di-' . ($isQcColumn ? 'Packing' : 'Jahit'))
                        ->default($sisa) 
                        ->maxValue($sisa) 
                        ->minValue(1)
                        ->suffix('Pcs')
                        ->extraInputAttributes(['class' => 'text-lg font-bold text-success-600']),
                ];
            })
            ->action(function (array $data, array $arguments) {
                $idVal = (int) ($arguments['recordId'] ?? 0);
                $realId = $idVal >= 1000000 ? ($idVal - 1000000) : $idVal;

                        // Gunakan database transaction agar proses simpan & update status aman
                        DB::transaction(function () use ($data, $realId, $idVal) {
                            $record = \App\Models\Order::find($realId);
                            $isQcColumn = $idVal >= 1000000 || $record->status === 'QC/Packing';
                            $currentStage = $isQcColumn ? 'QC/Packing' : $record->status;

                            \App\Models\ProductionOutput::create([
                                'order_id' => $record->id,
                                'employee_id' => auth()->user()->employee_id,
                                'stage' => $currentStage,
                                'qty' => $data['qty_input'],
                                'status' => 'Done',
                            ]);

                            $record->refresh();
                            $totalSelesaiSekarang = $record->outputs()->where('stage', $currentStage)->sum('qty');

                            if ($totalSelesaiSekarang >= $record->quantity) {
                                $newStatus = ($currentStage === 'Sewing') ? 'QC/Packing' : 'Done';
                                $record->update(['status' => $newStatus]);
                                
                                Notification::make()
                                    ->title('Pesanan ' . $record->order_number . ' Telah Selesai Tahap ' . $currentStage)
                                    ->body('Lanjut ke Tahap ' . $newStatus)
                                    ->success()
                                    ->send();

                                \App\Models\ProductionLog::where('order_id', $record->id)
                                    ->where('stage', $currentStage)
                                    ->whereIn('status', ['Sedang Diproses', 'Mulai'])
                                    ->update([
                                        'status' => 'Selesai',
                                        'output_qty' => $totalSelesaiSekarang,
                                        'timestamp' => now(),
                                    ]);
                            }

                            // 2. TAMBAHKAN CACHE INVALIDATION: Agar dashboard & tracking langsung terupdate
                            Cache::forget('dashboard_stats_admin');
                            Cache::forget('dashboard_stats_general');
                            Cache::forget("order_tracking_{$realId}");
                            // Bersihkan cache kinerja karena ada input qty baru
                            Cache::flush(); 

                            Notification::make()
                                ->title('Pesanan ' . $record->order_number . ' Berhasil dicicil ke Tahap Selanjutnya' )
                                ->body('Sebanyak ' . $data['qty_input'] . ' Pcs')
                                ->success()
                                ->send();
                        });
            });
    }
}