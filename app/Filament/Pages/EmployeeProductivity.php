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

    protected static bool $shouldRegisterNavigation = true;
    public ?string $startDate = null;
    public ?string $endDate = null;

    public function mount()
    {
        // Default: Tampilkan minggu ini jika belum ada filter
        if (! $this->startDate) {
            $this->startDate = now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
            $this->endDate = now()->startOfWeek(Carbon::MONDAY)->addDays(5)->format('Y-m-d');
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
                    $this->startDate = now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
                    $this->endDate = now()->startOfWeek(Carbon::MONDAY)->addDays(5)->format('Y-m-d');
                })
                ->visible(fn () => $this->startDate !== now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d')),
        ];
    }

    public function getViewData(): array
    {
        $user = Auth::user();
        $employee = $user->employee;

        $defaultStart = now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $defaultEnd = now()->startOfWeek(Carbon::MONDAY)->addDays(5)->format('Y-m-d');

        $outputs = ProductionOutput::with('order')
            ->where('employee_id', $employee->id)
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $totalQty = $outputs->sum('qty');
        $currentRate = ($employee->rate_per_pcs > 0) 
            ? $employee->rate_per_pcs 
            : ($employee->roleRate->rate_per_pcs ?? 0);

        $isFiltered = ($this->startDate !== $defaultStart) || ($this->endDate !== $defaultEnd);

        return [
            'outputs' => $outputs->take(10),
            'total_minggu_ini' => $totalQty, 
            'estimasi_gaji' => $totalQty * $currentRate,
            'rate_per_pcs' => $currentRate,
            'job_desk' => $employee->job_desk,
            'label_periode' => \Carbon\Carbon::parse($this->startDate)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->translatedFormat('d F Y'),
            'is_filtered' => $isFiltered,
        ];
    }
}