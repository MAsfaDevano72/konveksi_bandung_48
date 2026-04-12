<?php
namespace App\Filament\Widgets;

use App\Models\GarmentModel;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class GarmentModelTable extends BaseWidget
{
    protected static ?string $heading = '2. Harga Jahit Baju / Pcs (Khusus Penjahit)';
    protected static bool $isDiscovered = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(GarmentModel::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Model Baju'),
                Tables\Columns\TextColumn::make('tailor_rate')
                    ->label('Upah Jahit / Pcs')
                    ->money('IDR')
                    ->color('warning')
                    ->suffix(' / Pcs'),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('Harga Jual / Pcs')
                    ->money('IDR')
                    ->color('success')
                    ->suffix(' / Pcs'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Model Baju')
                    ->model(GarmentModel::class)
                    ->form([
                        \Filament\Forms\Components\TextInput::make('name')->label('Nama Model')->required(),
                        \Filament\Forms\Components\TextInput::make('tailor_rate')
                            ->label('Tarif Penjahit (Per Pcs)')
                            ->numeric()
                            ->prefix('IDR')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('sale_price')
                            ->label('Harga Jual (Per Pcs)')
                            ->numeric()
                            ->prefix('IDR')
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    \Filament\Forms\Components\TextInput::make('tailor_rate')->label('Tarif Penjahit')->numeric()->prefix('IDR'),
                    \Filament\Forms\Components\TextInput::make('sale_price')->label('Harga Jual')->numeric()->prefix('IDR'),
                ]),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}
