<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrders extends BaseWidget
{
    protected static ?int $sort = 3; 

    protected static ?string $heading = '📦 Pesanan Terbaru';
    

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::latest()->limit(5))
            ->columns([
                Split::make([
                    // BAGIAN 1: INFO UTAMA
                    Stack::make([
                        Tables\Columns\TextColumn::make('order_number')
                            ->weight('bold')
                            ->color('primary')
                            ->size('sm')
                            ->copyable(),
                        
                        Tables\Columns\TextColumn::make('agency_name')
                            ->size('xs')
                            ->icon('heroicon-m-building-office')
                            ->description(fn ($record) => $record->client_name), 
                    ])->space(1),

                    // BAGIAN 2: DETAIL PRODUK (Disembunyikan di mobile, muncul di desktop)
                    Stack::make([
                        Tables\Columns\TextColumn::make('product_name')
                            ->size('xs')
                            ->weight('bold')
                            ->formatStateUsing(fn ($state) => "Item: {$state}"),
                        
                        Tables\Columns\TextColumn::make('quantity')
                            ->size('xs')
                            ->color('gray')
                            ->suffix(' Pcs'),
                    ])->visibleFrom('md'),

                    // BAGIAN 3: STATUS & DEADLINE
                    Stack::make([
                        Tables\Columns\TextColumn::make('status')
                            ->badge()
                            ->size('xs')
                            ->color(fn (string $state): string => match ($state) {
                                'Waiting', 'Menunggu' => 'gray',
                                'Potong', 'Cutting'   => 'warning',
                                'Jahit', 'Sewing'     => 'info',
                                'QC/Packing'             => 'purple',
                                'Done', 'Selesai'     => 'success',
                                default               => 'gray',
                            }),
                        
                        Tables\Columns\TextColumn::make('deadline')
                            ->date('d M Y') 
                            ->size('xs')
                            ->color('danger')
                            ->icon('heroicon-m-calendar-days'),
                    ])->alignment('right'),
                ])->collapsed(false), 
            ])
            ->contentGrid([
                'default' => 1,
                'md' => 1,
            ])
            ->paginated(false);
    }

    
    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner', 'Tailor']);
    }
}