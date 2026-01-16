<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Produksi';
    protected static ?string $title = 'Pesanan & SPK';
    protected static ?string $navigationLabel = 'Pesanan & SPK';
    protected static ?string $recordTitleAttribute = 'order_number';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
    

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan')
                    ->description('Detail pelanggan dan produk yang dipesan')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Nomor SPK')
                            ->default('SPK-' . date('Ymd') . '-' . rand(100, 999))
                            ->readonly()
                            ->required(),
                        Forms\Components\TextInput::make('agency_name')
                            ->label('Nama Instansi')
                            ->required(),
                        Forms\Components\TextInput::make('client_name')
                            ->label('Nama Pemesan')
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor HP')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('product_name')
                            ->label('Nama Produk')
                            ->placeholder('Contoh: Hoodie Custom Kemhan')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah (Pcs)')
                            ->numeric(),
                        Forms\Components\DatePicker::make('deadline')
                            ->label('Tenggat Waktu (Deadline)'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Waiting' => 'Menunggu',
                                'Cutting' => 'Potong',
                                'Sewing' => 'Jahit',
                                'QC/Packing' => 'QC/Packing',
                                'Done' => 'Selesai',
                            ])
                            ->default('Waiting')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. SPK')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agency_name')
                    ->label('Nama Instansi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Nama Pemesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->suffix(' pcs'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Waiting' => 'gray',
                        'Cutting' => 'warning',
                        'Sewing' => 'info',
                        'QC/Packing' => 'purple',
                        'Done' => 'success',
                    })
                    ->label('Status')
                    ->searchable()
                    ->default('Waiting'),
                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Waiting' => 'Menunggu',
                        'Cutting' => 'Potong',
                        'Sewing' => 'Jahit',
                        'QC/Packing' => 'QC/Packing',
                        'Done' => 'Selesai',
                    ]),
            ])
            ->recordAction(Tables\Actions\ViewAction::class)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->modalHeading('Rincian Pesanan & SPK')
                    ->modalWidth('4xl')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->closeModalByClickingAway()
                    ->modalFooterActions([]),
                
                Tables\Actions\EditAction::make(),
            ])
            ->recordUrl(null);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Tabs::make('Detail SPK')
                    ->columnSpanFull()
                    ->tabs([
                        // --- TAB 1: INFORMASI PESANAN ---
                        Infolists\Components\Tabs\Tab::make('Informasi Umum')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                Infolists\Components\Grid::make(2)->schema([
                                    Infolists\Components\Section::make('Identitas Pesanan')
                                        ->columnSpan(1)
                                        ->schema([
                                            Infolists\Components\TextEntry::make('order_number')
                                                ->label('Kode SPK')
                                                ->weight('bold')
                                                ->color('primary')
                                                ->copyable(),
                                            Infolists\Components\TextEntry::make('product_name')
                                                ->label('Nama Produk'),
                                            Infolists\Components\TextEntry::make('deadline')
                                                ->label('Deadline')
                                                ->date('d F Y')
                                                ->color('danger')
                                                ->weight('bold'),
                                        ]),
                                    
                                    Infolists\Components\Section::make('Data Pelanggan')
                                        ->columnSpan(1)
                                        ->schema([
                                            Infolists\Components\TextEntry::make('agency_name')->label('Instansi'),
                                            Infolists\Components\TextEntry::make('client_name')->label('Pemesan'),
                                            Infolists\Components\TextEntry::make('phone')
                                                ->label('WhatsApp')
                                                ->icon('heroicon-m-chat-bubble-left-right')
                                                ->color('success')
                                                ->suffixAction(
                                                    Infolists\Components\Actions\Action::make('chatWA')
                                                        ->icon('heroicon-m-paper-airplane')
                                                        ->url(fn ($record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->phone))
                                                        ->openUrlInNewTab()
                                                ),
                                        ]),
                                ]),
                            ]),

                        // --- TAB 2: SPESIFIKASI PRODUKSI ---
                        Infolists\Components\Tabs\Tab::make('Spesifikasi & Bahan')
                            ->icon('heroicon-m-scissors')
                            ->schema([
                                Infolists\Components\Section::make()->schema([
                                    Infolists\Components\Grid::make(3)->schema([
                                        Infolists\Components\TextEntry::make('status')->badge()->color('warning'),
                                        Infolists\Components\TextEntry::make('quantity')->label('Target')->suffix(' Pcs'),
                                        Infolists\Components\TextEntry::make('created_at')->label('Tanggal Masuk')->date('d F Y'),
                                    ]),
                                    
                                    // Detail Bahan (Ambil dari Log seperti logika Kanban Anda)
                                    Infolists\Components\TextEntry::make('bahan_model')
                                        ->label('Model Baju & Warna')
                                        ->state(function ($record) {
                                            $log = $record->productionLogs()->where('notes', 'like', '%Model:%')->first();
                                            return $log ? str($log->notes)->before(' | SIZES_DATA:') : 'Data belum diinput.';
                                        })
                                        ->listWithLineBreaks()
                                        ->bulleted(),

                                    // Detail Size (Layout Badge)
                                    Infolists\Components\TextEntry::make('size_details')
                                        ->label('Rincian Size (Hasil Potong)')
                                        ->html()
                                        ->state(function ($record) {
                                            $log = $record->productionLogs()->where('notes', 'like', '%SIZES_DATA:%')->first();
                                            if (!$log) return '<span class="text-gray-400">Belum ada data potong.</span>';
                                            $details = json_decode(str($log->notes)->after('SIZES_DATA:'), true);
                                            return collect($details)->map(fn($item) => 
                                                "<span class='inline-block bg-blue-50 text-blue-700 px-2 py-1 rounded border border-blue-200 text-xs font-bold mr-1 mb-1'>{$item['size']}: {$item['qty']} Pcs</span>"
                                            )->implode('');
                                        }),
                                ]),
                            ]),

                        // --- TAB 3: PROGRESS PEGAWAI ---
                        Infolists\Components\Tabs\Tab::make('Kontributor & Hasil')
                            ->icon('heroicon-m-users')
                            ->schema([
                                Infolists\Components\TextEntry::make('production_outputs')
                                    ->label('')
                                    ->html()
                                    ->state(function ($record) {
                                        $cacheKey = "order_tracking_{$record->id}";

                                        $outputs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($record) {
                                            return $record->outputs()
                                                ->selectRaw('employee_id, stage, sum(qty) as total_qty')
                                                ->groupBy('employee_id', 'stage')
                                                ->get();
                                        });

                                        if ($outputs->isEmpty()) return 'Belum ada setoran produksi.';

                                        $html = '<table class="w-full text-sm border-collapse border border-gray-200">';
                                        $html .= '<tr class="bg-gray-50 text-left"><th class="p-2 border">Pegawai</th><th class="p-2 border">Bagian</th><th class="p-2 border text-right">Hasil</th></tr>';
                                        foreach ($outputs as $output) {
                                            $name = DB::table('employees')->where('id', $output->employee_id)->value('name') ?? 'N/A';
                                            $html .= "<tr><td class='p-2 border'>$name</td><td class='p-2 border'>$output->stage</td><td class='p-2 border text-right font-bold'>$output->total_qty Pcs</td></tr>";
                                        }
                                        $html .= '</table>';
                                        return $html;
                                    }),
                            ]),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}