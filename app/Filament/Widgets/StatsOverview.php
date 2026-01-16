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
        return Auth::user()->hasAnyRole(['Admin', 'Owner', 'Tailor', 'Cutting', 'QC/Packing', 'Gudang']);
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $isAdminOrOwner = $user->hasAnyRole(['Admin', 'Owner']);
        $isGudang = $user->hasRole('Gudang');

        // Menentukan apakah user berhak melihat data gudang (Admin, Owner, atau Gudang)
        $hasWarehouseAccess = $isAdminOrOwner || $isGudang;

        $cacheKey = "dashboard_stats_" . $user->roles->first()->name;

        $data = Cache::remember($cacheKey, 3600, function () use ($isAdminOrOwner, $hasWarehouseAccess) {
            return [
                'totalOrders' => Order::count(),
                'inProcess' => Order::whereNotIn('status', ['Waiting', 'Done'])->count(),
                'doneOrders' => Order::where('status', 'Done')->count(),
                'lowStock' => $hasWarehouseAccess ? Inventory::whereRaw('stock <= min_stock')->count() : 0,
                'totalItems' => $hasWarehouseAccess ? Inventory::count() : 0,
                'inventoryValue' => $hasWarehouseAccess ? (Inventory::query()->selectRaw('SUM(stock * price) as total_value')->value('total_value') ?? 0) : 0,
            ];
        });

        // Membuat array untuk kartu Produksi
        $productionStats = [
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

        // Membuat array untuk kartu Gudang (extraStats)
        $warehouseStats = [
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

        // LOGIKA PENGEMBALIAN (RETURN) BERDASARKAN ROLE
        if ($isGudang) {
            return $warehouseStats; // Hanya tampilkan kartu gudang
        }

        if ($isAdminOrOwner) {
            return array_merge($productionStats, $warehouseStats); // Tampilkan semua
        }

        return $productionStats; // Role lain (Tailor, dll) hanya lihat produksi
    }
}