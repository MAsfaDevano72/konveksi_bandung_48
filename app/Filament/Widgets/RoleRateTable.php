<?php
namespace App\Filament\Widgets;

use App\Models\RoleRate;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RoleRateTable extends BaseWidget
{
    protected static ?string $heading = '1. Tarif Pegawai Standar (Harian/Pcs)';
    protected static bool $isDiscovered = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(RoleRate::query())
            ->columns([
                Tables\Columns\TextColumn::make('role_name')->label('Job Desk')->badge(),
                Tables\Columns\TextColumn::make('rate_type')
                    ->label('Tipe Upah')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pcs' => 'success',
                        'daily' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pcs' => 'Per Pcs (Borongan)',
                        'daily' => 'Harian (Fixed)',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('rate_amount')
                    ->label('Tarif Kerja')
                    ->money('IDR'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Tarif Standar')
                    ->model(RoleRate::class)
                    ->form([
                        \Filament\Forms\Components\Select::make('role_name')
                            ->options([
                                'Tailor' => 'Tailor (Penjahit)',
                                'Cutting' => 'Cutting (Pemotong)',
                                'QC/Packing' => 'QC/Packing',
                                'Gudang' => 'Gudang',
                            ])
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->reactive(),
                        \Filament\Forms\Components\Select::make('rate_type')
                            ->label('Tipe Upah')
                            ->options([
                                'pcs' => 'Per Pcs (Borongan)',
                                'daily' => 'Harian',
                            ])
                            ->default(fn ($get) => $get('role_name') === 'Tailor' ? 'pcs' : 'daily')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('rate_amount')
                            ->label(fn ($get) => $get('rate_type') === 'daily' ? 'Nominal Per Hari' : 'Tarif Per Pcs (Standar)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->helperText(fn ($get) => $get('role_name') === 'Tailor' 
                                ? 'Ini adalah tarif dasar. Tarif spesifik akan mengikuti Model Baju.' 
                                : 'Staf ini akan dibayar flat per hari kerja.'),
                                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    \Filament\Forms\Components\Select::make('rate_type')
                        ->label('Tipe Upah')
                        ->options([
                            'pcs' => 'Per Pcs (Borongan)',
                            'daily' => 'Harian (Fixed)',
                        ]),
                    \Filament\Forms\Components\TextInput::make('rate_amount')->label('Tarif Kerja')->numeric()->prefix('Rp'),
                ]),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}