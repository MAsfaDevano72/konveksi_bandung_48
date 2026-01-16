<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleRateResource\Pages;
use App\Filament\Resources\RoleRateResource\RelationManagers;
use App\Models\RoleRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleRateResource extends Resource
{
    protected static ?string $model = RoleRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $navigationLabel = 'Tarif Pegawai';
    protected static ?string $title = 'Manajemen Tarif Pegawai';
    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role_name')
                    ->options([
                        'Owner' => 'Owner (Pemilik)',
                        'Admin' => 'Admin Konveksi',
                        'Tailor' => 'Tailor (Penjahit)',
                        'Cutting' => 'Cutting (Pemotong)',
                        'QC/Packing' => 'QC/Packing',
                        'Gudang' => 'Gudang (Admin Gudang)',
                    ])
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('rate_per_pcs')
                    ->label('Tarif per Pcs (Standar)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role_name')
                    ->label('Job Desk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rate_per_pcs')
                    ->label('Tarif per Pcs (Standar)')
                    ->money('idr', true)
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRoleRates::route('/'),
            'create' => Pages\CreateRoleRate::route('/create'),
            'edit' => Pages\EditRoleRate::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}
