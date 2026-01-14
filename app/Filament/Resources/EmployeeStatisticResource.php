<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeStatisticResource\Pages;
use App\Models\Employee;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class EmployeeStatisticResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Kinerja Pegawai';
    protected static ?string $pluralLabel = 'Statistik Kinerja Pegawai';
    protected static ?string $navigationGroup = 'Manajemen Pegawai';
    protected static ?string $slug = 'statistik-kinerja-pegawai';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Employee $record) => $record->job_desk),

                Tables\Columns\TextColumn::make('rate_info')
                    ->label('Tarif / Pcs')
                    ->getStateUsing(function (Employee $record) {
                        $rate = $record->rate_per_pcs > 0 
                            ? $record->rate_per_pcs 
                            : ($record->roleRate->rate_per_pcs ?? 0);
                        return 'Rp ' . number_format($rate, 0, ',', '.');
                    })
                    ->badge()
                    ->color(fn (Employee $record) => $record->rate_per_pcs > 0 ? 'warning' : 'gray')
                    ->description(fn (Employee $record) => $record->rate_per_pcs > 0 ? 'Tarif Khusus' : 'Standar'),

                // Total Sewing
                Tables\Columns\TextColumn::make('total_sewing')
                    ->label('Total Jahit')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        $start = $livewire->tableFilters['from'] ?? now()->startOfWeek(Carbon::MONDAY);
                        $until = $livewire->tableFilters['until'] ?? now()->startOfWeek(Carbon::MONDAY)->addDays(5);

                        return $record->outputs()
                            ->where('stage', 'Sewing')
                            ->whereBetween('created_at', [Carbon::parse($start)->startOfDay(), Carbon::parse($until)->endOfDay()])
                            ->sum('qty') . ' Pcs';
                    })
                    ->color('primary'),

                // 2. Update Kolom Total QC/Pack
                Tables\Columns\TextColumn::make('total_qc')
                    ->label('Total QC/Pack')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        $start = $livewire->tableFilters['from'] ?? now()->startOfWeek(Carbon::MONDAY);
                        $until = $livewire->tableFilters['until'] ?? now()->startOfWeek(Carbon::MONDAY)->addDays(5);

                        return $record->outputs()
                            ->where('stage', 'QC/Packing')
                            ->whereBetween('created_at', [Carbon::parse($start)->startOfDay(), Carbon::parse($until)->endOfDay()])
                            ->sum('qty') . ' Pcs';
                    })
                    ->color('success'),

                // 3. Update Kolom Estimasi Upah
                Tables\Columns\TextColumn::make('total_upah')
                    ->label('Estimasi Upah')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        $start = $livewire->tableFilters['from'] ?? now()->startOfWeek(Carbon::MONDAY);
                        $until = $livewire->tableFilters['until'] ?? now()->startOfWeek(Carbon::MONDAY)->addDays(5);
                        
                        $totalQty = $record->outputs()
                            ->whereBetween('created_at', [Carbon::parse($start)->startOfDay(), Carbon::parse($until)->endOfDay()])
                            ->sum('qty');
                            
                        $rate = $record->rate_per_pcs > 0 ? $record->rate_per_pcs : ($record->roleRate->rate_per_pcs ?? 0);
                        
                        return 'Rp ' . number_format($totalQty * $rate, 0, ',', '.');
                    })
                    ->fontFamily('mono')
                    ->color('warning')
                    ->weight('bold'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeStatistics::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['owner', 'admin']);
    }
}