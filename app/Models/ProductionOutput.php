<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class ProductionOutput extends Model
{
    protected $fillable = [
        'order_id',
        'employee_id',
        'stage',
        'qty',
        'status',
        'notes',
    ];

    protected static function booted()
    {
        // Fungsi pembantu untuk hapus cache
        $clearDashboardCache = function () {
            Cache::forget('dashboard_stats_admin');
            Cache::forget('dashboard_stats_general');
        };

        static::saved($clearDashboardCache);   // Saat tambah/edit data
        static::deleted($clearDashboardCache); // Saat hapus data

        static::saved(function ($output) {
            \Illuminate\Support\Facades\Cache::forget("order_tracking_{$output->order_id}");
            \Illuminate\Support\Facades\Cache::flush(); 
        });
    }

    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getSizeDetailAttribute()
    {
        // 1. Cari log produksi dari order ini yang stagenya 'Cutting'
        $cuttingLog = $this->order->productionLogs
            ->where('stage', 'Cutting')
            ->first();

        if (!$cuttingLog || !str_contains($cuttingLog->notes, 'SIZES_DATA:')) {
            return 'All Size';
        }

        try {
            // 2. Ekstrak bagian JSON dari string notes
            $parts = explode('SIZES_DATA:', $cuttingLog->notes);
            $jsonStr = $parts[1] ?? '[]';
            
            $sizes = json_decode($jsonStr, true);

            if (is_array($sizes) && count($sizes) > 0) {
                // 3. Gabungkan ukuran (contoh: "M, L, XL")
                return collect($sizes)->pluck('size')->implode(', ');
            }
        } catch (\Exception $e) {
            return 'All Size';
        }

        return 'All Size';
    }
}
