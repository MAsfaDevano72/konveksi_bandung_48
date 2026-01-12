<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionLog extends Model
{
    protected $fillable = [
        'order_id',
        'employee_id',
        'stage',
        'status',
        'notes',
        'output_qty',
        'reject_qty',
        'timestamp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    protected $casts = [
        'notes' => 'array',
    ];
}

