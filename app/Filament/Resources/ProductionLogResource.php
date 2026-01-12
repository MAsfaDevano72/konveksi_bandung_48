<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionLogResource\Pages;
use App\Filament\Resources\ProductionLogResource\RelationManagers;
use App\Models\ProductionLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductionLogResource extends Resource
{
    protected static ?string $model = ProductionLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Produksi';
    protected static ?string $slug = 'riwayat-produksi';
    protected static ?string $navigationLabel = 'Riwayat Produksi';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }

    public static function form(Form $form): Form
    {
        // 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('timestamp')
                    ->dateTime('d F Y H:i')
                    ->label('Waktu'),
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Nomor Pesanan')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('order.agency_name')
                    ->label('Pesanan'),
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Pegawai'),
                Tables\Columns\TextColumn::make('stage')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                                'Waiting', 'Menunggu' => 'gray',
                                'Potong', 'Cutting'   => 'warning',
                                'Jahit', 'Sewing'     => 'info',
                                'QC/Packing'             => 'purple',
                                'Done', 'Selesai'     => 'success',
                                default               => 'gray',
                            })
                    ->label('Tahap'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('output_qty')
                    ->label('Hasil')
                    ->alignCenter()
                    ->color('success')
                    ->numeric(),
                Tables\Columns\TextColumn::make('reject_qty')
                    ->label('Reject')
                    ->numeric()
                    ->alignCenter()
                    ->color('danger'),

            ])
            ->defaultSort('timestamp', 'desc')
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
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
            'index' => Pages\ListProductionLogs::route('/'),
        ];
    }
}
