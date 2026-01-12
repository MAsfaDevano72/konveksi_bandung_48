<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_number',
        'agency_name',
        'client_name',
        'phone',
        'product_name',
        'quantity',
        'deadline',
        'status',
        'is_completed',
    ];

    protected static function booted()
    {
        $clearDashboard = function () {
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_admin');
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_general');
        };

        static::created($clearDashboard);
        static::updated($clearDashboard);
        static::deleted($clearDashboard);
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function productionLogs() {
        return $this->hasMany(ProductionLog::class);
    }

    public function productionOutputs() {
        return $this->hasMany(ProductionOutput::class, 'order_id');
    }

    public function outputs() {
        return $this->hasMany(ProductionOutput::class);
    }

    public function getTotalSewingAttribute() {
        return $this->outputs()->where('stage', 'Sewing')->sum('qty');
    }

    public function getTotalQCAttribute() {
        return $this->outputs()->where('stage', 'QC/Packing')->sum('qty');
    }

    protected $casts = [
        'is_completed' => 'boolean',
    ];
}
