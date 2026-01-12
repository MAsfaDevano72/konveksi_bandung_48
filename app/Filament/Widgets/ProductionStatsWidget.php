<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductionStatsWidget extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Menunggu Antrian', Order::where('status', 'Waiting')->count())
                ->description('Menunggu Produksi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('gray'),
            Stat::make('Sedang Dipotong', Order::where('status', 'Cutting')->count())
                ->description('Tahap Cutting')
                ->descriptionIcon('heroicon-m-scissors')
                ->color('warning'),
            Stat::make('Sedang Dijahit', Order::where('status', 'Sewing')->count())
                ->description('Tahap Penjahitan')
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('info'),
            Stat::make('Sedang Packing', Order::where('status', 'QC/Packing')->count())
                ->description('Tahap QC & Packing')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('purple'),
            Stat::make('Selesai Hari Ini', Order::where('status', 'Done')->whereDate('updated_at', today())->count())
                ->description('Total Siap Kirim')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['Admin', 'Owner', 'Tailor']);
    }
}