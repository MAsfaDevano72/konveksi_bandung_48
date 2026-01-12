<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Analisis Tren Pesanan';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 2;
    protected static ?string $maxHeight = '450px';

    // Mengatur filter untuk memilih tampilan waktu
    protected function getFilters(): ?array
    {
        return [
            'per_month' => 'Tampilan Bulanan (Semua)',
            'per_week'  => '12 Minggu Terakhir',
            'per_day'   => '30 Hari Terakhir',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter ?? 'per_month';

        $start = now()->subMonths(12);
        $end = now();

        if ($activeFilter === 'per_day') {
            $start = now()->subDays(30);
            $queryIn = Trend::model(Order::class)->between(start: $start, end: $end)->perDay();
            $queryDone = Trend::query(Order::where('status', 'Done'))->between(start: $start, end: $end)->perDay();
            $format = 'd M';
        } elseif ($activeFilter === 'per_week') {
            $start = now()->subWeeks(12);
            $queryIn = Trend::model(Order::class)->between(start: $start, end: $end)->perWeek();
            $queryDone = Trend::query(Order::where('status', 'Done'))->between(start: $start, end: $end)->perWeek();
            $format = 'W'; // Kita hanya butuh angka minggunya saja nanti
        } else {
            $firstOrder = Order::oldest()->first()?->created_at ?? now()->subMonths(5);
            $start = Carbon::parse($firstOrder)->startOfMonth();
            $queryIn = Trend::model(Order::class)->between(start: $start, end: $end)->perMonth();
            $queryDone = Trend::query(Order::where('status', 'Done'))->between(start: $start, end: $end)->perMonth();
            $format = 'M Y';
        }

        $orderIn = $queryIn->count();
        $orderDone = $queryDone->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan Masuk',
                    'data' => $orderIn->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Pesanan Selesai',
                    'data' => $orderDone->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#10b981',
                    'borderRadius' => 4,
                ],
            ],
            // PERBAIKAN DI SINI:
            'labels' => $orderIn->map(function (TrendValue $value) use ($activeFilter, $format) {
                if ($activeFilter === 'per_week') {
                    [$year, $week] = explode('-', $value->date);
                    return "Mg-" . $week . " (" . $year . ")";
                }

                return Carbon::parse($value->date)->translatedFormat($format);
            }),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner', 'Tailor', 'Cutting', 'QC/Packing']);
    }
}