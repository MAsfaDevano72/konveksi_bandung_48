<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int $cacheDuration = 3600;

    protected int | string | array $columnSpan = [
        'default' => 'full', 
        'md' => 'full',      
        'lg' => 'full',      
    ];

    public static function canView(): bool
    {
        return Auth::user()->hasAnyRole(['Admin', 'Owner', 'Tailor', 'Cutting', 'QC/Packing']);
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $isAdminOrOwner = $user->hasAnyRole(['Admin', 'Owner']);

        $cacheKey = $isAdminOrOwner ? 'dashboard_stats_admin' : 'dashboard_stats_general';

        $data = Cache::remember($cacheKey, 3600, function () use ($isAdminOrOwner) {
            return [
                'totalOrders' => Order::count(),
                'inProcess' => Order::whereNotIn('status', ['Waiting', 'Done'])->count(),
                'doneOrders' => Order::where('status', 'Done')->count(),
                'lowStock' => $isAdminOrOwner ? Inventory::whereRaw('stock <= min_stock')->count() : 0,
                'totalItems' => $isAdminOrOwner ? Inventory::count() : 0,
                'inventoryValue' => $isAdminOrOwner ? (Inventory::query()->selectRaw('SUM(stock * price) as total_value')->value('total_value') ?? 0) : 0,
            ];
        }); 

            // Stats yang bisa dilihat semua orang (Produksi)
            $stats = [
                Stat::make('Total Pesanan', $data['totalOrders'])
                    ->description('Semua pesanan terdaftar')
                    ->icon('heroicon-m-clipboard-document-list'),

                Stat::make('Dalam Proses', $data['inProcess'])
                    ->description('Sedang di lantai produksi')
                    ->color('warning')
                    ->icon('heroicon-m-arrow-path'),

                Stat::make('Pesanan Selesai', $data['doneOrders'])
                    ->description('Total pesanan sukses')
                    ->color('success')
                    ->icon('heroicon-m-check-badge'),
            ];

            // Stats tambahan hanya untuk Admin & Owner (Keuangan & Gudang)
            if ($isAdminOrOwner) {
                $totalInventoryValue = Inventory::query()
                    ->selectRaw('SUM(stock * price) as total_value')
                    ->value('total_value') ?? 0;

                $extraStats = [
                    Stat::make('Stok Menipis', $data['lowStock'])
                        ->description('Bahan baku perlu re-stock')
                        ->color('danger')
                        ->icon('heroicon-m-exclamation-triangle'),

                    Stat::make('Total Item Gudang', $data['totalItems'])
                        ->icon('heroicon-m-archive-box')
                        ->description('Jenis bahan baku di gudang'),

                    Stat::make('Nilai Inventory', 'Rp ' . number_format($data['inventoryValue'], 0, ',', '.'))
                        ->description('Total aset bahan baku')
                        ->color('primary')
                        ->icon('heroicon-m-banknotes'),
                ];

                // Gabungkan kedua array
                $stats = array_merge($stats, $extraStats);
            }

            return $stats;
    }
}