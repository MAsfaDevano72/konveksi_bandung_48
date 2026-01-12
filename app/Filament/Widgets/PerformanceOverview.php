<?php
namespace App\Filament\Widgets;

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
        // Set default awal saat pertama kali load agar tidak error null
        $this->filters['from'] = now()->startOfWeek(Carbon::MONDAY)->translatedFormat('Y-m-d');
        $this->filters['until'] = now()->startOfWeek(Carbon::MONDAY)->addDays(5)->translatedFormat('Y-m-d');
    }

    // Fungsi untuk menangkap update dari tombol filter
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

        $data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 1800, function () use ($start, $end) {
            return [
                'totalSewing' => ProductionOutput::where('stage', 'Sewing')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('qty'),

                'totalQc' => ProductionOutput::where('stage', 'QC/Packing')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('qty'),

                'totalUpah' => ProductionOutput::query()
                    ->join('employees', 'production_outputs.employee_id', '=', 'employees.id')
                    ->leftJoin('role_rates', 'employees.job_desk', '=', 'role_rates.role_name')
                    ->whereBetween('production_outputs.created_at', [$start, $end])
                    ->sum(DB::raw('production_outputs.qty * COALESCE(NULLIF(employees.rate_per_pcs, 0), role_rates.rate_per_pcs, 0)')),
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

    public static function canView(): bool
    {
        return str_contains(request()->url(), 'kinerja-pegawai');
    }
}