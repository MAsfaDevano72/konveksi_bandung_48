<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeStatisticResource\Pages;
use App\Models\Employee;
use App\Models\ProductionLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            // Sembunyikan Owner & Admin dari daftar
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->whereNotIn('job_desk', ['Owner', 'Admin'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('job_desk')
                    ->label('Job Desk')
                    ->searchable()
                    ->sortable()
                    ->badge('warning'),

                // Kolom Tipe Gaji
                Tables\Columns\TextColumn::make('rate_type')
                    ->label('Tipe')
                    ->getStateUsing(fn (Employee $record) => strtoupper($record->roleRate->rate_type ?? 'pcs'))
                    ->badge()
                    ->color(fn ($state) => $state === 'DAILY' ? 'success' : 'info'),

                // Kolom Tarif Dasar
                Tables\Columns\TextColumn::make('base_rate')
                    ->label('Tarif')
                    ->getStateUsing(function (Employee $record) {
                        $rate = $record->roleRate->rate_amount ?? 0;
                        return 'Rp ' . number_format($rate, 0, ',', '.');
                    })
                    ->description(fn (Employee $record) => ($record->roleRate->rate_type ?? '') === 'pcs' ? '/ Pcs' : '/ Hari'),

                // Total Hasil Kerja (Qty)
                Tables\Columns\TextColumn::make('total_qty')
                    ->label('Total Hasil')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        // Sinkronisasi dengan filter tombol di ListPage
                        $start = $livewire->tableFilters['from'];
                        $until = $livewire->tableFilters['until'];

                        $qty = $record->outputs()
                            ->whereBetween('created_at', [Carbon::parse($start)->startOfDay(), Carbon::parse($until)->endOfDay()])
                            ->sum('qty');
                        
                        return $qty . ' Pcs';
                    }),

                // 3. PERBAIKAN: Hitungan Hari Kerja (Ucup Fix)
                Tables\Columns\TextColumn::make('attendance_days')
                    ->label('Hari Kerja')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        if (($record->roleRate->rate_type ?? '') !== 'daily') return '-';
                        
                        $start = $livewire->tableFilters['from'];
                        $until = $livewire->tableFilters['until'];

                        // Gunakan COUNT(DISTINCT DATE(timestamp)) supaya jam tidak bikin hari jadi ganda
                        $days = ProductionLog::where('employee_id', $record->id)
                            ->whereBetween('timestamp', [Carbon::parse($start)->startOfDay(), Carbon::parse($until)->endOfDay()])
                            ->count(DB::raw('DISTINCT DATE(timestamp)'));

                        return $days . ' Hari';
                    })
                    ->color('primary'),

                // 4. ESTIMASI UPAH (SINKRON DENGAN LOGIKA EMPLOYEE PRODUCTIVITY)
                Tables\Columns\TextColumn::make('estimasi_upah')
                    ->label('Estimasi Upah')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        $start = $livewire->tableFilters['from'];
                        $until = $livewire->tableFilters['until'];
                        $dateRange = [Carbon::parse($start)->startOfDay(), Carbon::parse($until)->endOfDay()];

                        $salaryType = $record->roleRate->rate_type ?? 'pcs';
                        $standardRate = $record->roleRate->rate_amount ?? 0;
                        $totalIncome = 0;

                        if ($salaryType === 'daily') {
                            // Hitung unik hari berdasarkan ProductionLog
                            $uniqueDays = ProductionLog::where('employee_id', $record->id)
                                ->whereBetween('timestamp', $dateRange)
                                ->count(DB::raw('DISTINCT DATE(timestamp)'));
                            
                            $totalIncome = $uniqueDays * $standardRate;
                        } else {
                            // Hitung borongan (Tailor rate dari model baju)
                            $outputs = $record->outputs()
                                ->with(['order.garmentModel'])
                                ->whereBetween('created_at', $dateRange)
                                ->get();

                            foreach ($outputs as $output) {
                                // Ambil rate khusus tailor dari model baju, jika tidak ada pakai standar rate
                                $modelRate = $output->order->garmentModel->tailor_rate ?? $standardRate;
                                $totalIncome += ($output->qty * $modelRate);
                            }
                        }

                        return 'Rp ' . number_format($totalIncome, 0, ',', '.');
                    })
                    ->fontFamily('mono')
                    ->color('warning')
                    ->weight('bold'),
            ])
            ->filters([]) // Kosongkan karena Anda sudah pakai Button Action di ListPage
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeStatistics::route('/'),
        ];
    }
}