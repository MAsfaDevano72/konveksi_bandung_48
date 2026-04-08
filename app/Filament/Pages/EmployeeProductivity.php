<?php

namespace App\Filament\Pages;

use App\Models\ProductionOutput;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeProductivity extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Produktivitas Saya';
    protected static ?string $title = 'Catatan Hasil Kerja';
    protected static string $view = 'filament.pages.employee-productivity';

    public ?string $startDate = null;
    public ?string $endDate = null;

    public function mount()
    {
        // Default: Periode Minggu - Sabtu minggu berjalan
        if (! $this->startDate) {
            $this->startDate = now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
            $this->endDate = now()->startOfWeek(Carbon::SUNDAY)->addDays(6)->format('Y-m-d');
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner', 'Tailor', 'Cutting', 'QC/Packing']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('filterByDate')
                ->label('Filter Tanggal')
                ->icon('heroicon-m-funnel')
                ->color('primary')
                ->form([
                    DatePicker::make('start_date')
                        ->label('Dari Tanggal')
                        ->default($this->startDate)
                        ->required(),
                    DatePicker::make('end_date')
                        ->label('Sampai Tanggal')
                        ->default($this->endDate)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->startDate = $data['start_date'];
                    $this->endDate = $data['end_date'];
                })
                ->modalHeading('Filter Hasil Kerja')
                ->modalSubmitActionLabel('Terapkan Filter'),
            
            Action::make('resetFilter')
                ->label('Reset')
                ->color('danger')
                ->icon('heroicon-m-x-mark')
                ->action(function () {
                    $this->startDate = now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                    $this->endDate = now()->startOfWeek(Carbon::SUNDAY)->addDays(6)->format('Y-m-d');
                })
                ->visible(fn () => $this->startDate !== now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d')),
        ];
    }

    public function getViewData(): array
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        // Pastikan employee ditemukan
        if (!$employee) return [];

        // Ambil data output (Gunakan nama kolom 'qty' sesuai image_7d9934.jpg)
        $outputs = ProductionOutput::with(['order.garmentModel',
                                            'order.inventory',
                                            'order.productionLogs'])
            ->where('employee_id', $employee->id)
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->latest()
            ->get();

        // Ambil tipe upah (pcs/daily)
        $salaryType = $employee->roleRate->rate_type ?? 'pcs'; 
        $standardRate = $employee->roleRate->rate_amount ?? 0;

        $dailyGrouped = [];
        if ($salaryType === 'daily') {
            $dailyGrouped = $outputs->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
        }


        $totalIncome = 0;
        $workSummary = 0;

        if ($salaryType === 'daily') {
            // HITUNG HARIAN
            $uniqueDays = $dailyGrouped->count();
            $workSummary = $uniqueDays; 
            $totalIncome = $uniqueDays * $standardRate;
        } else {
            // HITUNG BORONGAN (Gunakan kolom 'qty')
            $workSummary = $outputs->sum('qty'); 
            
            foreach ($outputs as $output) {
                $modelRate = $output->order->garmentModel->tailor_rate ?? $standardRate;
                $totalIncome += ($output->qty * $modelRate);
            }
        }

        $defaultStart = now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $isFiltered = ($this->startDate !== $defaultStart);

        return [
            'outputs' => $outputs,
            'salary_type' => $salaryType,
            'daily_grouped' => $dailyGrouped,
            'work_summary' => $workSummary,
            'total_income' => $totalIncome,
            'standard_rate' => $standardRate,
            'job_desk' => $employee->job_desk,
            'label_periode' => Carbon::parse($this->startDate)->translatedFormat('d F Y') . ' - ' . Carbon::parse($this->endDate)->translatedFormat('d F Y'),
            'is_filtered' => $isFiltered,
        ];
    }
}