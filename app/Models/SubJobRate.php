<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubJobRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role_id',
        'rate_type',
        'rate_amount',
        'is_active',
    ];
}