<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $recordTitleAttribute = "name";

    protected static ?string $navigationGroup = 'Manajemen Gudang';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $title = 'Inventori Bahan Baku';
    protected static ?string $navigationLabel = 'Gudang Bahan Baku';
    protected static ?string $slug = 'inventory-bahan-baku';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sku')
                    ->label('SKU/Kode Barang')
                    ->disabled()
                    ->placeholder('Otomatis Terisi oleh sistem')
                    ->dehydrated(false)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Bahan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Jenis Barang')
                    ->options([
                        'Kain' => 'Kain',
                        'Benang' => 'Benang',
                        'Aksesoris' => 'Aksesoris',
                    ])
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('color')
                    ->label('Warna')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->required()
                    ->disabledOn('edit')
                    ->default(0),
                Forms\Components\TextInput::make('length')
                    ->label('Panjang (Yard/Meter)')
                    ->numeric()
                    ->nullable()
                    ->default(0)
                    ->suffix('Yard')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'Kain') 
                    ->required(fn (Forms\Get $get) => $get('type') === 'Kain')
                    ->helperText('Isi panjang kain per roll jika jenisnya Kain'),
                Forms\Components\Select::make('unit')
                    ->label('Satuan')
                    ->options([
                        'Kg' => 'Kg',
                        'Meter' => 'Meter',
                        'Pcs' => 'Pcs',
                        'Rol' => 'Rol',
                        'Pack' => 'Bungkus'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Harga Bahan Baku (Beli)')
                    ->numeric()
                    ->prefix('Rp')
                    ->nullable()
                    ->default(0)
                    ->rules(['regex:/^\d{1,10}(\.\d{1,2})?$/']), 
                Forms\Components\TextInput::make('min_stock')
                    ->label('Stok Minimum')
                    ->numeric()
                    ->default(0),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('Kode Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('color')
                    ->label('Warna')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('length')
                    ->label('Panjang')
                    ->numeric()
                    ->alignCenter()
                    ->default(0)
                    ->suffix(' yard'),
                Tables\Columns\TextColumn::make('min_stock')
                    ->label('Min.stok')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->alignCenter()
                    ->date('d-M-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function (Inventory $record): string {
                        if ($record->stock <= 0) {
                            return 'Habis';
                        }
                        if ($record->stock <= $record->min_stock) {
                            return 'Rendah';
                        }
                        return 'Aman';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Habis' => 'danger',
                        'Rendah' => 'warning',
                        'Aman' => 'success',
                    })
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Kain' => 'Kain',
                        'Benang' => 'Benang',
                        'Aksesoris' => 'Aksesoris',
                    ]),
                Tables\Filters\SelectFilter::make('unit')
                    ->options([
                        'Kg' => 'Kg',
                        'Meter' => 'Meter',
                        'Pcs' => 'Pcs',
                        'Rol' => 'Rol',
                        'Pack' => 'Bungkus'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Hanya Bahan Aktif')
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
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }

    
}
