<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlert extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ]; 

    protected static ?string $heading = '⚠️ Peringatan Stok Rendah';

    public function table(Table $table): Table
    {
        return $table
            ->query(Inventory::whereRaw('stock <= min_stock'))
            ->paginated([5])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Bahan Baku')
                    ->weight('bold')
                    ->description(fn (Inventory $record): string => $record->sku),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->color(fn ($state, Inventory $record) => $record->stock <= 0 ? 'danger' : 'warning')
                    ->formatStateUsing(fn ($state, Inventory $record) => "{$state} {$record->unit}"),

                // 3. Gabungkan Warna & Jenis ke dalam satu kolom jika perlu menghemat ruang
                Tables\Columns\TextColumn::make('type')
                    ->label('Info')
                    ->description(fn (Inventory $record): string => "Warna: {$record->color}"),

                Tables\Columns\IconColumn::make('status')
                    ->label('Kondisi')
                    ->getStateUsing(fn (Inventory $record) => $record->stock <= 0 ? 'kritis' : 'rendah')
                    ->options([
                        'heroicon-m-x-circle' => 'kritis',
                        'heroicon-m-exclamation-triangle' => 'rendah',
                    ])
                    ->colors([
                        'danger' => 'kritis',
                        'warning' => 'rendah',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('restock')
                    ->label('Isi')
                    ->url(fn () => url('/admin/inventories/'))
                    ->icon('heroicon-m-arrow-path')
                    ->button() 
                    ->size('xs'),
            ]);
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}