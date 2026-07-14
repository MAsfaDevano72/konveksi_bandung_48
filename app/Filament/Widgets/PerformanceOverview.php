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
        
        // 1. Hitung Total Sewing & QC
        $sewing = ProductionOutput::where('stage', 'Sewing')
            ->whereBetween('created_at', [$start, $end])
            ->sum('qty');

        $qc = ProductionOutput::where('stage', 'QC/Packing')
            ->whereBetween('created_at', [$start, $end])
            ->sum('qty');

        // 2. Hitung Estimasi Upah 
        $totalUpah = 0;

        $employees = Employee::whereNotIn('job_desk', ['Owner', 'Admin'])->get();

        foreach ($employees as $emp) {
            $salaryType = strtolower($emp->roleRate->rate_type ?? 'pcs');
            
            if (!blank($emp->rate_per_pcs) && $emp->rate_per_pcs > 0) {
                $baseRate = $emp->rate_per_pcs;
            } else {
                $baseRate = $emp->roleRate->rate_amount ?? 0;
            }

            if ($salaryType === 'daily') { 
                $days = \App\Models\Attendance::where('employee_id', $emp->id)
                    ->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                    ->whereIn('status', ['Hadir', 'Lembur'])
                    ->count();

                $otHours = \App\Models\Attendance::where('employee_id', $emp->id)
                    ->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                    ->whereIn('status', ['Hadir', 'Lembur'])
                    ->sum('overtime_hours');
                
                $totalUpah += ($days * $baseRate) + ($otHours * 15000);
            } else {
                // Hitung Borongan
                $outputs = $emp->outputs()
                    ->with(['order.garmentModel'])
                    ->whereBetween('created_at', [$start, $end])
                    ->get();

                foreach ($outputs as $output) {
                    $modelRate = $output->order->garmentModel->tailor_rate ?? $baseRate;
                    $totalUpah += ($output->qty * $modelRate);
                }
            }
        }

        return [
            Stat::make('Total Hasil Jahit', $sewing . ' Pcs')
                ->description('Seluruh hasil jahitan')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('primary'),

            Stat::make('Total Hasil QC/Packing', $qc . ' Pcs')
                ->description('Total barang lolos QC')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            // SEKARANG AKAN LANGSUNG REAL-TIME MENAMPILKAN RP 320.000
            Stat::make('Estimasi Total Upah', 'Rp ' . number_format($totalUpah, 0, ',', '.'))
                ->description('Total pengeluaran gaji')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}