<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubJobRateResource\Pages;
use App\Models\SubJobRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB; 

class SubJobRateResource extends Resource
{
    protected static ?string $model = SubJobRate::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Keuangan & Payroll';
    protected static ?string $navigationLabel = 'Tarif Sub-Pekerjaan';
    protected static ?string $modelLabel = 'Tarif Sub-Pekerjaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Sub-Pekerjaan')
                            ->placeholder('Contoh: Pasang Kancing, Buang Benang')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('role_id')
                            ->label('Kategori Divisi (Role)')
                            ->options(function () {
                                return DB::table('roles')->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\ToggleButtons::make('rate_type')
                            ->label('Tipe Upah')
                            ->options([
                                'pcs' => 'Borongan (Per Pcs)',
                                'daily' => 'Harian (Daily)',
                            ])
                            ->colors([
                                'pcs' => 'primary',
                                'daily' => 'success',
                            ])
                            ->icons([
                                'pcs' => 'heroicon-o-cube',
                                'daily' => 'heroicon-o-calendar',
                            ])
                            ->default('pcs')
                            ->required(),

                        Forms\Components\TextInput::make('rate_amount')
                            ->label('Nominal Tarif/Upah')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pekerjaan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role_id')
                    ->label('Divisi / Role')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(function ($state) {
                        return DB::table('roles')->where('id', $state)->value('name') ?? '-';
                    }),

                Tables\Columns\TextColumn::make('rate_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pcs' => 'primary',
                        'daily' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pcs' => 'Borongan',
                        'daily' => 'Harian',
                    }),

                Tables\Columns\TextColumn::make('rate_amount')
                    ->label('Tarif')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role_id')
                    ->label('Filter Divisi')
                    ->options(function () {
                        return DB::table('roles')->pluck('name', 'id');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubJobRates::route('/'),
            'create' => Pages\CreateSubJobRate::route('/create'),
            'edit' => Pages\EditSubJobRate::route('/{record}/edit'),
        ];
    }
}