<?php

namespace App\Filament\Resources\IncomeReportResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class IncomeReportWidgets extends BaseWidget
{
    public ?string $startDate = null;
    public ?string $endDate = null;

    protected $listeners = ['updateFilter' => 'updateWidgetData'];

    public function updateWidgetData($data)
    {
        $this->startDate = $data['startDate'];
        $this->endDate = $data['endDate'];
    }

    protected function getStats(): array
    {
        // Pastikan format tanggal konsisten
        $dari = $this->startDate ?: now()->startOfMonth()->format('Y-m-d');
        $sampai = $this->endDate ?: now()->today()->format('Y-m-d');

        $currentQuery = Order::whereDate('created_at', '>=', $dari)
                            ->whereDate('created_at', '<=', $sampai);

        $totalOmzet = $currentQuery->sum('total_price');
        $totalPesanan = $currentQuery->count();
        $rataRata = $totalPesanan > 0 ? $totalOmzet / $totalPesanan : 0;

        // Logika Tren
        $diffInDays = Carbon::parse($dari)->diffInDays(Carbon::parse($sampai)) + 1;
        $prevDari = Carbon::parse($dari)->subDays($diffInDays)->format('Y-m-d');
        $prevSampai = Carbon::parse($dari)->subDay()->format('Y-m-d');

        $prevOmzet = Order::whereDate('created_at', '>=', $prevDari)
                        ->whereDate('created_at', '<=', $prevSampai)
                        ->sum('total_price');

        $selisihOmzet = $totalOmzet - $prevOmzet;
        $trendIcon = $selisihOmzet >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $selisihOmzet >= 0 ? 'success' : 'danger';
        $trendLabel = $selisihOmzet >= 0 ? 'Meningkat' : 'Menurun';

        return [
            Stat::make('Total Omzet', 'Rp ' . number_format($totalOmzet, 0, ',', '.'))
                ->description('Total pendapatan kotor')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Pesanan', $totalPesanan . ' SPK')
                ->description('Jumlah pesanan diproses')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),

            Stat::make('Rata-rata Pendapatan', 'Rp ' . number_format($rataRata, 0, ',', '.'))
                ->description('Nilai rata-rata per SPK')
                ->descriptionIcon('heroicon-m-presentation-chart-line'),

            Stat::make('Tren Pendapatan', 'Rp ' . number_format(abs($selisihOmzet), 0, ',', '.'))
                ->description($trendLabel . ' dibanding periode sebelumnya')
                ->descriptionIcon($trendIcon)
                ->color($trendColor),
        ];
    }
}