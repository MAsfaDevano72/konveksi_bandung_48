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
        'qty_roll',
        'used_yard',
        'deadline',
        'status',
        'is_completed',
        'is_stock_production', 
        'inventory_id',
        'garment_model_id',
        'unit_price',
        'total_price',
    ];

    protected static function booted()
    {
        parent::booted();

        $clearDashboard = function () {
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_admin');
            \Illuminate\Support\Facades\Cache::forget('dashboard_stats_general');
        };

        static::creating(function ($order) {
            $prefix = $order->is_stock_production ? 'FAST-' : 'SPK-';
            $lastId = \App\Models\Order::max('id') ?? 0;
            $nextId = $lastId + 1;
            $order->order_number = $prefix . now()->format('Ymd') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            if ($order->garment_model_id) {
                $model = \App\Models\GarmentModel::find($order->garment_model_id);
                if ($model) {
                    $order->unit_price = $model->sale_price;
                    $order->total_price = (float)$order->quantity * (float)$model->sale_price;
                }
            }
        });

        static::updating(function ($order) {
            if ($order->isDirty('garment_model_id') && $order->garment_model_id) {
                $model = \App\Models\GarmentModel::find($order->garment_model_id);
                
                if ($model) {
                    $order->unit_price = $model->sale_price;
                    
                    $order->total_price = (float)$order->quantity * (float)$model->sale_price;
                }
            }

            if ($order->isDirty('quantity') && !$order->isDirty('garment_model_id')) {
                $order->total_price = (float)$order->quantity * (float)$order->unit_price;
            }
        });

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

    public function garmentModel(): BelongsTo {
        return $this->belongsTo(GarmentModel::class, 'garment_model_id');
    }

    public function inventory(): BelongsTo 
    {
        return $this->belongsTo(Inventory::class, 'inventory_id')->withTrashed();
    }

    protected $casts = [
        'is_completed' => 'boolean',
    ];
}
