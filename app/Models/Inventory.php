<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Inventory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sku',
        'name',
        'type',
        'color',
        'stock',
        'unit',
        'price',
        'length',
        'min_stock',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(MaterialUsage::class);
    }

    protected static function booted()
    {
        static::creating(function ($inventory) {
            if (empty($inventory->sku)) {
                $lock = Cache::lock('generating_sku_inventory', 5);

                try {
                    $lock->block(3); // Tunggu maksimal 3 detik jika sedang dikunci proses lain

                    $prefix = match ($inventory->type) {
                        'Kain' => 'KN',
                        'Benang' => 'BNG',
                        'Aksesoris' => 'AKS',
                        default => 'BRG',
                    };

                    // Ambil ID terakhir dengan query yang cepat
                    $latestId = self::max('id') ?? 0;
                    $nextId = $latestId + 1;
                    $randomPart = rand(100000, 999999);

                    $inventory->sku = $prefix . $nextId . '-' . $randomPart;

                } finally {
                    $lock->release(); // Lepas kunci
                }
            }
        });

        static::created(function ($inventory) {
            // Catat log barang baru (Logika Asli)
            $inventory->histories()->create([
                'type' => 'Masuk',
                'quantity' => $inventory->stock,
                'description' => 'Stok Awal Barang Baru',
                'reference_type' => 'Initial',
            ]);
        });

        // 2. OPTIMASI CACHE MANAGEMENT
        $clearInventoryCache = function ($inventory) {
            Cache::forget("inventory_status_{$inventory->id}");
            Cache::forget('dashboard_stats_admin');
            Cache::forget('inventory_list_all');
        };

        static::saved($clearInventoryCache);
        static::deleted($clearInventoryCache);
    }
}
