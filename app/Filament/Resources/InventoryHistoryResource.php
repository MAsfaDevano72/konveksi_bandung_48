<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryHistoryResource\Pages;
use App\Models\InventoryHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class InventoryHistoryResource extends Resource
{
    protected static ?string $model = InventoryHistory::class;
    protected static ?string $navigationGroup = 'Manajemen Gudang';
    protected static ?string $title = 'Riwayat Bahan Baku';
    protected static ?string $navigationLabel = 'Riwayat Bahan Baku';
    protected static ?string $slug = 'riwayat-inventori-bahan-baku';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Informasi Detail Transaksi')
                ->schema([
                    Forms\Components\Grid::make(3) // Kita ubah jadi 3 kolom agar lebih compact
                        ->schema([
                            Forms\Components\TextInput::make('inventory_sku')
                                ->label('Kode SKU')
                                ->formatStateUsing(fn ($record) => $record?->inventory?->sku)
                                ->disabled(),

                            Forms\Components\TextInput::make('inventory_name')
                                ->label('Nama Bahan Baku')
                                ->formatStateUsing(fn ($record) => $record?->inventory?->name)
                                ->disabled(),

                            Forms\Components\TextInput::make('inventory_color')
                                ->label('Warna')
                                ->formatStateUsing(fn ($record) => $record?->inventory?->color ?? '-')
                                ->disabled(),

                            Forms\Components\TextInput::make('type')
                                ->label('Tipe Transaksi')
                                ->disabled(),

                            Forms\Components\TextInput::make('quantity')
                                ->label('Jumlah (Qty)')
                                ->disabled()
                                ->suffix(fn ($record) => $record?->inventory?->unit ?? 'Unit'),

                            Forms\Components\TextInput::make('inventory_length')
                                ->label('Panjang Per Rol')
                                ->formatStateUsing(fn ($record) => $record?->inventory?->length ? $record->inventory->length . ' Yard' : '-')
                                ->disabled(),
                                
                            Forms\Components\DateTimePicker::make('created_at')
                                ->label('Waktu Pencatatan')
                                ->locale('id')
                                ->disabled()
                                ->columnSpan(2), // Tanggal dibuat agak panjang
                        ]),
                    
                    Forms\Components\Textarea::make('notes')
                        ->label('Keterangan / Catatan')
                        ->rows(3)
                        ->disabled()
                        ->columnSpanFull(),
                ])
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('inventory.sku')
                    ->label('SKU')
                    ->searchable(),

                Tables\Columns\TextColumn::make('inventory.name')
                    ->label('Bahan Baku')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        'Masuk' => 'success',
                        'Keluar' => 'danger',
                        'Terpakai' => 'warning', 
                        default => 'gray',      
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Masuk' => 'heroicon-o-arrow-trending-up',
                        'Keluar' => 'heroicon-o-arrow-trending-down',
                        'Terpakai' => 'heroicon-o-scissors',
                        default => 'heroicon-o-document-text',
                    }),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Keterangan')
                    ->alignLeft()
                    ->limit(30)
                    ->default(' - '),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->alignCenter()
                    ->dateTime('d F Y H:i')
                    ->sortable(),
            ])
            ->actions([
                // Tambahkan modalWidth agar pop-up terlihat proporsional
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detail Riwayat Inventori')
                    ->modalWidth('lg'), 
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Masuk' => 'Masuk',
                        'Keluar' => 'Keluar',
                        'Terpakai' => 'Terpakai',
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryHistories::route('/')
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}