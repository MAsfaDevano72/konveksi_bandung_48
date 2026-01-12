<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleRate extends Model
{
    protected $fillable = [
        'role_name',
        'rate_per_pcs',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'job_desk', 'role_name');
    }
}
