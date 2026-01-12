<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\ProductionLog;
use App\Models\User;
use App\Models\ProductionOutput;
use App\Models\Inventory; 
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; 
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
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

    
    public bool $searchable = true;
    public bool $disableEditModal = true; 
    
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ProductionStatsWidget::class,
        ];
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
        ];
    }

    protected function records(): Collection
    {
        $orders = Order::where('is_completed', false)->get();
        $kanbanRecords = collect();

        foreach ($orders as $order) {
            $kanbanRecords->push($order);

            // 2. Logika Shadow (Hanya jika sedang tahap Sewing)
            if ($order->status === 'Sewing') {
                $totalJahit = $order->outputs()->where('stage', 'Sewing')->sum('qty') ?? 0;
                $totalQc = $order->outputs()->where('stage', 'QC/Packing')->sum('qty') ?? 0;

                // Jika jahit sudah jalan tapi QC belum beres, munculkan bayangan di QC
                if ($totalJahit > 0 && $totalQc < $order->quantity) {
                    // Gunakan replicate() agar tidak merusak data model asli di database
                    $shadow = $order->replicate();
                    $shadow->id = "qcshadow-" . $order->id; // ID unik untuk tampilan
                    $shadow->status = 'QC/Packing'; // Paksa tampil di kolom QC
                    
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


    #[On('status-changed')]
    public function onStatusChanged(int|string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        $lock = Cache::lock("kanban_move_order_{$recordId}", 10);

        if ($lock->get()) {
            try {
                $record = Order::find($recordId);
                $user = auth()->user();

                if ($record) {
                    // --- PROTEKSI DRAG & DROP PER ROLE (Logika Asli Anda) ---
                    $isAuthorized = false;

                    if ($user->hasAnyRole(['Admin', 'Owner'])) {
                        $isAuthorized = true;
                    } elseif ($status === 'Cutting' && $user->hasRole('Cutting')) {
                        $isAuthorized = true;
                    } elseif ($status === 'Sewing' && $user->hasRole('Tailor')) {
                        $isAuthorized = true;
                    } elseif ($status === 'QC/Packing' && $user->hasRole('QC/Packing')) {
                        $isAuthorized = true;
                    }

                    if (!$isAuthorized) {
                        Notification::make()
                            ->title('Akses Ditolak')
                            ->body("Anda tidak memiliki izin untuk memindahkan pesanan ke tahap $status.")
                            ->danger()
                            ->send();
                        
                        return; 
                    }

                    // Gunakan Transaction agar data DB konsisten
                    DB::transaction(function () use ($record, $status, $user) {
                        \App\Models\ProductionLog::where('order_id', $record->id)
                        ->whereIn('status', ['Mulai', 'Sedang Diproses'])
                        ->delete(); 

                        // 1. Update status di tabel Order
                        $record->update(['status' => $status]);

                        // 2. Buat Log Baru (Log Tunggal)
                        \App\Models\ProductionLog::create([
                            'order_id'    => $record->id,
                            'employee_id' => $user->employee_id ?? 1,
                            'stage'       => $status,      
                            'status'      => 'Mulai',
                            'output_qty'  => 0,
                            'notes'       => 'Dipindahkan via Kanban',
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
                ->body('Pesanan ini sedang diproses oleh pengguna lain. Silakan coba lagi sebentar lagi.')
                ->warning()
                ->send();
        }
    }

    // --- Action Button Logika ---

    // 1. Action Mulai Normal (Jahit & QC)
    public function startStage(int $recordId): void
    {
        $record = Order::find($recordId);

        if (!$record) return;

        if ($record->status === 'Cutting') {
            Notification::make()->title('Gunakan tombol Mulai Cutting')->warning()->send();
            return;
        }

        ProductionLog::create([
            'order_id' => $record->id,
            'employee_id' => auth()->user()->employee_id,
            'stage' => $record->status,
            'status' => 'Sedang Diproses',
            'output_qty' => 0,
            'timestamp' => now(),
        ]);

        $currentStatusLabel = match($record->status) {
            'Sewing' => 'Jahit',
            'QC/Packing' => 'QC & Packing',
            default => $record->status
        };

        $recipients = Cache::remember('users_with_production_roles', 3600, function () {
            return User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();
        });
        
        Notification::make()
            ->title("Produksi $currentStatusLabel Dimulai")
            ->body("Pesanan $record->order_number - $record->agency_name mulai dikerjakan.")
            ->success()
            ->sendToDatabase($recipients)
            ->send();
    }

    // 2. Action Selesai Normal (Jahit & QC)
    public function finishStage(): Action
    {
        return Action::make('finishStage')
            ->record(fn (array $arguments) => Order::find($arguments['recordId']))
            ->mountUsing(fn (Forms\ComponentContainer $form, array $arguments) => $form->fill([
                'record_id' => $arguments['recordId']
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
                        'reject_qty' => $calculatedReject, // Sisa otomatis jadi reject
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
                'status' => 'Selesai', // Selesai menunggu, lanjut potong
                'timestamp' => now(),
            ]);

            $recipients = Cache::remember('users_with_production_roles', 3600, function () {
                    return User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();
                });
            Notification::make()
                ->title("Pesanan $record->order_number untuk $record->agency_name dipindahkan ke Tahap Potongan")
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
                $form->fill([
                    'record_id' => $arguments['recordId'],
                    'order_number' => $record?->order_number,
                    'agency_name' => $record?->agency_name,
                    'client_name' => $record?->client_name,
                    'total_target' => $record?->quantity,
                ]);
            })
            ->label("Input Bahan & Mulai Cutting")
            ->form([
                Forms\Components\Hidden::make('record_id'),
                Forms\Components\Section::make('Detail Pesanan')
                ->compact()
                ->columns(4)
                ->schema([
                    Forms\Components\Placeholder::make('order_number')
                        ->label('No. Order :')
                        ->content(fn ($get) => $get('order_number')),
                    Forms\Components\Placeholder::make('agency_name')
                        ->label('Nama Instansi : ')
                        ->content(fn ($get) => $get('agency_name')),
                    Forms\Components\Placeholder::make('client_name')
                        ->label('Atas Nama :')
                        ->content(fn ($get) => $get('client_name')),
                    Forms\Components\Placeholder::make('total_target')
                        ->label('Target Pesanan :')
                        ->content(fn ($get) => $get('total_target') . " Pcs"),
                ]),

                Forms\Components\Section::make('Pemakaian Bahan Baku')
                    ->description("Pilih kain dan tentukan model baju untuk pesanan ini. Pastikan data yang dimasukkan sudah benar.")
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('model_baju')
                        ->label('Model Baju / Artikel')
                        ->placeholder('Contoh: Kaftan Silk, Kebaya Modern, dll')
                        ->required()
                        ->columnSpanFull(),

                        Forms\Components\Select::make('inventory_id')
                            ->label('Pilih Kain (Stok tersedia)')
                            ->options(function() {
                                return Inventory::where('type', 'Kain')
                                    ->where('stock', '>', 0)
                                    ->get(['id', 'name', 'stock', 'color', 'length'])
                                    ->mapWithKeys(function ($item) {
                                        return [$item->id => "{$item->name} - {$item->color} - ( {$item->length} Yard ) || Sisa: ({$item->stock} Rol)"];
                                    });
                            })
                            ->searchable()
                            ->preload() 
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('qty_roll')
                                ->label('Jumlah Rol Digunakan')
                                ->numeric()
                                ->required()
                                ->columnSpanFull()
                                ->minValue(1) 
                                ->rules([
                                    fn (Forms\Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                        $inventory = \App\Models\Inventory::find($get('inventory_id'));
                                        if ($inventory && $value > $inventory->stock) {
                                            $fail("Stok tidak mencukupi! Maksimal penggunaan adalah {$inventory->stock} Rol, sesuai stok bahan yang ada.");
                                        }
                                    },
                                ]),
                    ]),
            ])
            ->action(function (array $data) {
                $inventoryId = $data['inventory_id'];
                
                // 1. ATOMIC LOCK: Kunci akses ke bahan baku ini agar tidak didecrement bersamaan
                $lock = Cache::lock("processing_inventory_{$inventoryId}", 10);

                if ($lock->get()) {
                    try {
                        return DB::transaction(function () use ($data, $inventoryId) {
                            $record = Order::find($data['record_id']);
                            $inventory = \App\Models\Inventory::find($inventoryId);

                            if (!$inventory) {
                                Notification::make()->title('Bahan tidak ditemukan')->danger()->send();
                                return;
                            }

                            // Re-check stok di dalam lock untuk memastikan data paling aktual
                            if ($inventory->stock < $data['qty_roll']) {
                                Notification::make()
                                    ->title('Stok Tidak Cukup!')
                                    ->body("Maaf, baru saja stok terupdate. Sisa stok {$inventory->name} saat ini {$inventory->stock} Rol.")
                                    ->danger()
                                    ->send();
                                return;
                            }

                            // Logika Asli: Simpan History & Decrement
                            \App\Models\InventoryHistory::create([
                                'inventory_id' => $inventory->id,
                                'type' => 'Terpakai',
                                'quantity' => $data['qty_roll'],
                                'notes' => "Produksi SPK: {$record->order_number} | Model: {$data['model_baju']}",
                            ]);

                            $inventory->decrement('stock', $data['qty_roll']); 

                            \App\Models\ProductionLog::create([
                                'order_id' => $record->id,
                                'employee_id' => auth()->user()->employee_id ?? 1,
                                'stage' => 'Cutting',
                                'status' => 'Sedang Diproses',
                                'notes' => "Model: {$data['model_baju']} | Bahan: {$inventory->name} | Warna: {$inventory->color} | Panjang: {$inventory->length} yard | Penggunaan: {$data['qty_roll']} Rol",
                                'timestamp' => now(),
                            ]);

                            // Invalidation: Hapus cache dashboard & status inventory
                            Cache::forget('dashboard_stats_admin');
                            Cache::forget("inventory_status_{$inventoryId}");

                            $recipients = Cache::remember('users_with_production_roles', 3600, function () {
                                return User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();
                            });

                            Notification::make()
                                ->title('Cutting Dimulai')
                                ->body("Stok {$inventory->name} telah dikurangi {$data['qty_roll']} Rol.")
                                ->success()
                                ->sendToDatabase($recipients)
                                ->send();
                        });
                    } finally {
                        $lock->release();
                    }
                } else {
                    Notification::make()
                        ->title('Sistem Sibuk')
                        ->body('Bahan baku ini sedang diproses oleh transaksi lain. Mohon tunggu sejenak.')
                        ->warning()
                        ->send();
                }
            });
    }

    // 5. Action Selesai Cutting (Input Size)
    public function finishCuttingAction(): Action
    {
        return Action::make('finishCutting')
            ->mountUsing(function (Forms\ComponentContainer $form, array $arguments) {
                $record = Order::find($arguments['recordId']);
                $templateSizes = [
                    ['size' => 'S',   'qty' => 0],
                    ['size' => 'M',   'qty' => 0],
                    ['size' => 'L',   'qty' => 0],
                    ['size' => 'XL',  'qty' => 0],
                ];

                $form->fill([
                    'record_id' => $arguments['recordId'],
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
                            ->label('No. Order')
                            ->content(fn ($get) => $get('order_number')),
                        Forms\Components\Placeholder::make('agency_name')
                            ->label('Nama Instansi')
                            ->content(fn ($get) => $get('agency_name')),
                        Forms\Components\Placeholder::make('client_name')
                            ->label('Atas Nama')
                            ->content(fn ($get) => $get('client_name')),
                        Forms\Components\Placeholder::make('total_target')
                            ->label('Target Keseluruhan')
                            ->content(fn ($get) => new \Illuminate\Support\HtmlString("<strong>{$get('total_target')} Pcs</strong>")),
                    ]),
                Forms\Components\Repeater::make('sizes')
                    ->label('Input Hasil Potongan Per Size')
                    ->schema([
                        Forms\Components\Select::make('size')
                            ->options(['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', 'XXL' => 'XXL'])
                            ->required()
                            ->searchable(false), 
                            
                        Forms\Components\TextInput::make('qty')
                            ->label('Jumlah (Pcs)')
                            ->numeric()
                            ->default(0) // Default 0
                            ->required()
                            ->rules([
                                fn (Forms\Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $totalInput = collect($get('../../sizes'))->sum('qty');
                                    $target = $get('../../total_target');
                                    
                                    if ($totalInput > $target) {
                                        $fail("Total hasil potong ({$totalInput}) tidak boleh melebihi target ({$target}).");
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
                
                // Filter: Hapus size yang qty-nya 0 agar tidak mengotori database/catatan
                $validSizes = collect($data['sizes'])
                    ->filter(fn($item) => $item['qty'] > 0)
                    ->values()
                    ->toArray();

                $totalOutput = collect($validSizes)->sum('qty');

                
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

                // Pindah ke Sewing
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
        return Action::make('selesaiTotalAction') // Samakan dengan nama di Blade
            ->label('Selesaikan Pesanan / Repeat Order')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            // Tambahkan mountUsing untuk menangkap recordId dari tombol
            ->mountUsing(fn (Forms\ComponentContainer $form, array $arguments) => $form->fill([
                'record_id' => $arguments['recordId'],
            ]))
            ->form([
                Forms\Components\Hidden::make('record_id'), // Hidden field untuk menyimpan ID
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
            ])
            ->action(function (array $data) {
                $record = Order::find($data['record_id']);
                $recipients = User::role(['Owner', 'Admin', 'Cutting', 'Tailor', 'QC/Packing'])->get();

                if (!$record) {
                    Notification::make()->title('Data tidak ditemukan')->danger()->send();
                    return;
                }

                if ($data['keputusan_akhir'] === 'finish') {
                    // OPSI 1: SELESAI
                    $record->update([
                        'is_completed' => true,
                    ]);

                    Notification::make()
                        ->title("Pesanan $record->order_number untuk $record->agency_name Diselesaikan")
                        ->body('Kartu telah diarsipkan dari papan produksi.')
                        ->success()
                        ->sendToDatabase($recipients)
                        ->send();

                } else {
                    ProductionLog::where('order_id', $record->id)->delete();
                    ProductionOutput::where('order_id', $record->id)->delete();
                    // OPSI 2: REPEAT ORDER
                    $record->update([
                        'status' => 'Waiting', 
                        'is_completed' => false,
                        'notes' => null, 
                    ]);

                    ProductionLog::create([
                        'order_id' => $record->id,
                        'employee_id' => Auth::user()->employee_id ?? 1,
                        'stage' => 'Waiting',
                        'status' => 'Mulai',
                        'notes' => 'Pesanan diulang (Repeat Order). Riwayat sebelumnya telah dibersihkan.',
                        'timestamp' => now(),
                    ]); 

                    Notification::make()
                        ->title("Pesanan $record->order_number untuk $record->agency_name Diulang")
                        ->body('Kembali ke tahap awal, melakukan produksi ulang.')
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
            ->record(fn(array $arguments) => Order::find($arguments['recordId']))
            ->infolist(function (Order $record): Infolist {
                return Infolists\Infolist::make()
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
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('product_name')
                                    ->label('Nama Produk :'),
                                Infolists\Components\TextEntry::make('agency_name')
                                    ->label('Nama Instansi :'),
                                Infolists\Components\TextEntry::make('client_name')
                                    ->label('Nama Pemesan :'),
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
                                    ->label('Tanggal Deadline :')
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
                                            $html .= '<td class="px-4 py-2 border"><span class="px-2 py-0.5 bg-gray-100 rounded text-[10px]">' . $output->stage . '</span></td>';
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
                            ->collapsed() // Kita sembunyikan defaultnya agar tidak terlalu panjang
                            ->schema([
                                Infolists\Components\ViewEntry::make('productionLogs')
                                    ->label('')
                                    ->view('filament.components.log-history-table')
                                    ->state(fn($record) => $record->productionLogs()->with('user')->orderBy('timestamp', 'desc')->get()),
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
            ->mountUsing(function (Forms\ComponentContainer $form, array $arguments) {
                $realId = str_replace('qcshadow-', '', $arguments['recordId'] ?? '');
                $record = \App\Models\Order::find($realId);
                if ($record) {
                    $form->model($record)->fill();
                }
            })
            ->form(function (array $arguments) { 
                $realId = str_replace('qcshadow-', '', $arguments['recordId'] ?? '');
                $record = \App\Models\Order::find($realId);
                
                if (! $record) {
                    return [Forms\Components\Placeholder::make('loading')->content('Memuat data...')];
                }

                $isQcColumn = str_contains($arguments['recordId'] ?? '', 'qcshadow') || $record->status === 'QC/Packing';
                $currentStage = $isQcColumn ? 'QC/Packing' : $record->status;

                $totalSelesaiTahapIni = $record->outputs()->where('stage', $currentStage)->sum('qty') ?? 0;
                
                if ($isQcColumn) {
                    $tersediaDariJahit = $record->outputs()->where('stage', 'Sewing')->sum('qty') ?? 0;
                    $sisa = max(0, $tersediaDariJahit - $totalSelesaiTahapIni);
                    $infoStatus = new \Illuminate\Support\HtmlString("<span class='text-primary-600 font-bold text-lg'>{$tersediaDariJahit} Pcs</span>");
                } else {
                    $sisa = max(0, $record->quantity - $totalSelesaiTahapIni);
                    $infoStatus = new \Illuminate\Support\HtmlString("<span class='text-warning-600 font-bold text-lg'>{$record->quantity} Pcs</span> <span class='text-gray-400'>(Sisa: {$sisa})</span>");
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
                            ->label($isQcColumn ? 'Barang Masuk dari Jahit' : 'Target Total Pesanan')
                            ->content($infoStatus),
                        Forms\Components\Placeholder::make('target')
                            ->label('Progres Tahap Ini')
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
                        ->default($sisa) 
                        ->maxValue($sisa) 
                        ->minValue(1)
                        ->suffix('Pcs')
                        ->extraInputAttributes(['class' => 'text-lg font-bold text-success-600']),
                ];
            })
            ->action(function (array $data, array $arguments) {
                $realId = str_replace('qcshadow-', '', $arguments['recordId'] ?? '');
                
                // 1. TAMBAHKAN LOCK: Mencegah tabrakan hitungan sum(qty)
                $lock = Cache::lock("cicil_hasil_lock_{$realId}", 10);

                if ($lock->get()) {
                    try {
                        // Gunakan database transaction agar proses simpan & update status aman
                        DB::transaction(function () use ($data, $realId, $arguments) {
                            $record = \App\Models\Order::find($realId);
                            
                            $isQcColumn = str_contains($arguments['recordId'] ?? '', 'qcshadow') || $record->status === 'QC/Packing';
                            $currentStage = $isQcColumn ? 'QC/Packing' : $record->status;

                            // 1. Simpan ke database (Logika Asli)
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
                    } finally {
                        $lock->release();
                    }
                } else {
                    Notification::make()
                        ->title('Gagal Input')
                        ->body('Data ini sedang diperbarui oleh sistem lain. Mohon tunggu sebentar.')
                        ->warning()
                        ->send();
                }
            });
    }
}