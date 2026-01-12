<?php

namespace App\Filament\Resources\EmployeeStatisticResource\Pages;

use App\Filament\Resources\EmployeeStatisticResource;
use App\Filament\Widgets\PerformanceOverview;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Carbon;

class ListEmployeeStatistics extends ListRecords
{
    protected static string $resource = EmployeeStatisticResource::class;

    public ?array $tableFilters = [];

    public function mount(): void
    {
        parent::mount();
        $this->resetToDefaultDates();
    }

    // Fungsi bantuan untuk mengatur tanggal ke default (Senin - Sabtu)
    protected function resetToDefaultDates(): void
    {
        $this->tableFilters['from'] = now()->startOfWeek(Carbon::MONDAY)->translatedFormat('Y-m-d');
        $this->tableFilters['until'] = now()->startOfWeek(Carbon::MONDAY)->addDays(5)->translatedFormat('Y-m-d');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('printReport')
                ->label('Cetak Laporan')
                ->color('success')
                ->icon('heroicon-o-printer')
                ->url(fn () => route('report.staff-productivity', [
                    'start_date' => $this->tableFilters['from'],
                    'end_date' => $this->tableFilters['until'],
                ]), shouldOpenInNewTab: true),

            // TOMBOL RESET: Muncul hanya jika filter berubah dari default
            Action::make('resetFilter')
                ->label('Reset Filter')
                ->icon('heroicon-m-x-mark')
                ->color('danger')
                ->action(function () {
                    $this->resetToDefaultDates();
                    $this->dispatch('updateFilter', data: $this->tableFilters);
                })
                ->visible(function () {
                    // Cek apakah tanggal saat ini berbeda dengan tanggal default
                    $defaultFrom = now()->startOfWeek(Carbon::MONDAY)->translatedFormat('Y-m-d');
                    $defaultUntil = now()->startOfWeek(Carbon::MONDAY)->addDays(5)->translatedFormat('Y-m-d');

                    return ($this->tableFilters['from'] !== $defaultFrom) || 
                           ($this->tableFilters['until'] !== $defaultUntil);
                }),

            // TOMBOL FILTER
            Action::make('filterTanggal')
                ->label('Filter Tanggal')
                ->icon('heroicon-m-funnel')
                ->color('warning')
                ->form([
                    DatePicker::make('from')
                        ->label('Dari Tanggal')
                        ->default($this->tableFilters['from'])
                        ->required(),
                    DatePicker::make('until')
                        ->label('Sampai Tanggal')
                        ->default($this->tableFilters['until'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->tableFilters['from'] = $data['from'];
                    $this->tableFilters['until'] = $data['until'];
                    $this->dispatch('updateFilter', data: $this->tableFilters);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PerformanceOverview::class,
        ];
    }

    public function getSubheading(): ?string
    {
        $from = Carbon::parse($this->tableFilters['from'])->translatedFormat('d M Y');
        $until = Carbon::parse($this->tableFilters['until'])->translatedFormat('d M Y');
        return "Menampilkan data: {$from} - {$until}";
    }
}