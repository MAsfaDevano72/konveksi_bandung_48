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
                        if (!blank($record->rate_per_pcs) && $record->rate_per_pcs > 0) {
                            $rate = $record->rate_per_pcs;
                        } else {
                            $rate = $record->roleRate->rate_amount ?? 0;
                        }
                        
                        return 'Rp ' . number_format($rate, 0, ',', '.');
                    })
                    ->description(function (Employee $record) {
                        $type = ($record->roleRate->rate_type ?? '');
                        $suffix = $type === 'pcs' ? '/ Pcs' : '/ Hari';
                        
                        if (!blank($record->rate_per_pcs) && $record->rate_per_pcs > 0) {
                            return $suffix . '';
                        }
                        return $suffix;
                    }),

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

                // 3.  Hitungan Hari Kerja 
                Tables\Columns\TextColumn::make('attendance_days')
                    ->label('Kehadiran')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        $start = $livewire->tableFilters['from'] ?? now()->startOfMonth();
                        $until = $livewire->tableFilters['until'] ?? now();

                        if (($record->roleRate->rate_type ?? '') === 'daily') {
                            // AMBIL DARI TABEL ATTENDANCE
                            return \App\Models\Attendance::where('employee_id', $record->id)
                                ->whereBetween('date', [$start, $until])
                                ->whereIn('status', ['Hadir', 'Lembur'])
                                ->count() . ' Hari';
                        }
                        
                        // Tetap borongan (Production Log)
                        return ProductionLog::where('employee_id', $record->id)
                            ->whereBetween('timestamp', [$start, $until])
                            ->count(DB::raw('DISTINCT DATE(timestamp)')) . ' Hari';
                    }),

                // Di dalam kolom estimasi_upah
                Tables\Columns\TextColumn::make('estimasi_upah')
                    ->getStateUsing(function (Employee $record, $livewire) {
                        $start = $livewire->tableFilters['from'] ?? now()->startOfMonth()->format('Y-m-d');
                        $until = $livewire->tableFilters['until'] ?? now()->format('Y-m-d');
                        
                        $salaryType = strtolower($record->roleRate->rate_type ?? 'pcs');
                        
                        if (!blank($record->rate_per_pcs) && $record->rate_per_pcs > 0) {
                            $baseRate = $record->rate_per_pcs;
                        } else {
                            $baseRate = $record->roleRate->rate_amount ?? 0;
                        }
                        
                        $totalIncome = 0;

                        if ($salaryType === 'daily') {
                            // Hitung Hari Kerja
                            $days = \App\Models\Attendance::where('employee_id', $record->id)
                                ->whereBetween('date', [$start, $until])
                                ->whereIn('status', ['Hadir', 'Lembur'])
                                ->count();
                            
                            // Hitung Jam Lembur
                            $otHours = \App\Models\Attendance::where('employee_id', $record->id)
                                ->whereBetween('date', [$start, $until])
                                ->whereIn('status', ['Hadir', 'Lembur'])
                                ->sum('overtime_hours');

                            // Rumus: (Hari Kerja * Tarif) + (Total Jam Lembur * 15.000)
                            $totalIncome = ($days * $baseRate) + ($otHours * 15000);
                        } else {
                            // Logika Borongan
                            $outputs = $record->outputs()
                                ->with(['order.garmentModel'])
                                ->whereBetween('created_at', [\Illuminate\Support\Carbon::parse($start)->startOfDay(), \Illuminate\Support\Carbon::parse($until)->endOfDay()])
                                ->get();

                            foreach ($outputs as $output) {
                                $modelRate = $output->order->garmentModel->tailor_rate ?? $baseRate;
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

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}