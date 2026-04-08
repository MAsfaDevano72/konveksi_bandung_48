<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GarmentModel extends Model
{
    protected $fillable = [
        'name', 
        'tailor_rate'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
