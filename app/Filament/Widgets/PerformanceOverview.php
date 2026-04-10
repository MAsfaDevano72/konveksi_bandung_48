<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\ProductionLog;
use App\Models\ProductionOutput;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On; 

class PerformanceOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;
    public array $filters = [];

    public function mount(): void
    {
        $this->filters['from'] = now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $this->filters['until'] = now()->startOfWeek(Carbon::SUNDAY)->addDays(6)->format('Y-m-d');
    }

    #[On('updateFilter')]
    public function updateFilter(array $data): void
    {
        $this->filters = $data;
    }

    protected function getStats(): array
    {
        $start = Carbon::parse($this->filters['from'])->startOfDay();
        $end = Carbon::parse($this->filters['until'])->endOfDay();

        $cacheKey = "perf_stats_" . $start->format('Ymd') . "_" . $end->format('Ymd');

        $data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 600, function () use ($start, $end) {
            
            // 1. Hitung Total Sewing & QC
            $sewing = ProductionOutput::where('stage', 'Sewing')
                ->whereBetween('created_at', [$start, $end])
                ->sum('qty');

            $qc = ProductionOutput::where('stage', 'QC/Packing')
                ->whereBetween('created_at', [$start, $end])
                ->sum('qty');

            // 2. Hitung Estimasi Upah (Logika Gabungan)
            $totalUpah = 0;

            // Ambil semua pegawai kecuali Admin/Owner
            $employees = Employee::whereNotIn('job_desk', ['Owner', 'Admin'])->get();

            foreach ($employees as $emp) {
                $salaryType = $emp->roleRate->rate_type ?? 'pcs';
                $standardRate = $emp->roleRate->rate_amount ?? 0;

                if ($salaryType === 'daily') {
                    $days = ProductionLog::where('employee_id', $emp->id)
                        ->whereBetween('timestamp', [$start, $end])
                        ->count(DB::raw('DISTINCT DATE(timestamp)'));
                    
                    $totalUpah += ($days * $standardRate);
                } else {
                    // Hitung Borongan (Tailor Rate dari Model Baju)
                    $outputs = $emp->outputs()
                        ->with(['order.garmentModel'])
                        ->whereBetween('created_at', [$start, $end])
                        ->get();

                    foreach ($outputs as $output) {
                        $modelRate = $output->order->garmentModel->tailor_rate ?? $standardRate;
                        $totalUpah += ($output->qty * $modelRate);
                    }
                }
            }

            return [
                'totalSewing' => $sewing,
                'totalQc' => $qc,
                'totalUpah' => $totalUpah,
            ];
        });

        return [
            Stat::make('Total Hasil Jahit', $data['totalSewing'] . ' Pcs')
                ->description('Seluruh hasil jahitan')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('primary'),

            Stat::make('Total Hasil QC/Packing', $data['totalQc'] . ' Pcs')
                ->description('Total barang lolos QC')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Estimasi Total Upah', 'Rp ' . number_format($data['totalUpah'], 0, ',', '.'))
                ->description('Total pengeluaran gaji')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}