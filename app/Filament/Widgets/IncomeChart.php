<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class IncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Pendapatan';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '450px';
    
    // Memberikan filter dropdown pada Chart
    protected function getFilters(): ?array
    {
        return [
            'bulanan' => 'Bulanan',
            'harian' => 'Harian',
            'mingguan' => 'Mingguan',
            'tahunan' => 'Tahunan',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter ?? 'bulanan';
        $query = Order::query();

        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // Logika penarikan data berdasarkan filter
        if ($activeFilter === 'harian') {
            // 2. Ambil data dari DB
            $rawData = $query->select(
                    DB::raw('DATE(created_at) as date'), 
                    DB::raw('SUM(total_price) as total')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy('date')
                ->pluck('total', 'date'); // Format: ['2026-04-15' => 500000]

            // 3. Generate semua tanggal dalam 7 hari terakhir agar tidak ada yang bolong
            $data = collect();
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $dateString = $date->format('Y-m-d');
                $data->put($dateString, [
                    'label' => $date->translatedFormat('d M'), // Contoh: 15 Apr
                    'total' => $rawData->get($dateString, 0), // Jika tidak ada di DB, set 0
                ]);
            }
            
            $labels = $data->pluck('label')->toArray();
            $chartData = $data->pluck('total')->toArray();

        } elseif ($activeFilter === 'mingguan') {
            $data = $query->select(DB::raw('YEARWEEK(created_at) as label'), DB::raw('SUM(total_price) as total'))
                ->where('created_at', '>=', now()->subWeeks(8))
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        } elseif ($activeFilter === 'tahunan') {
            $data = $query->select(DB::raw('YEAR(created_at) as label'), DB::raw('SUM(total_price) as total'))
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        } else {
            // Default: Bulanan
            $data = $query->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month_key'), 
                    DB::raw('SUM(total_price) as total')
                )
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('month_key')
                ->orderBy('month_key')
                ->get();
            
            // Perbaikan Label di sini: Ubah YYYY-MM menjadi 'M Y' (Contoh: Apr 26)
            $labels = $data->map(function($item) {
                return Carbon::parse($item->month_key . '-01')->translatedFormat('M y');
            })->toArray();
            
            $chartData = $data->pluck('total')->toArray();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (IDR)',
                    'data' => $chartData,
                    'fill' => 'start',
                    'tension' => 0.4, // Membuat garis menjadi melengkung (smooth)
                    'borderColor' => '#10b981', // Warna hijau emerald
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; 
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner']);
    }
}
