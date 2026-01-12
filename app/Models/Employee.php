<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'job_desk',
        'phone',
        'email',
        'address',
        'start_date',
        'status',
        'rate_per_pcs',
    ];

    // Relasi One-to-One: Setiap Employee memiliki satu User (akun login)
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function productionLogs() 
    {
        return $this->hasMany(ProductionLog::class);
    }

    public function roleRate()
    {
        return $this->belongsTo(RoleRate::class, 'job_desk', 'role_name');
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(ProductionOutput::class, 'employee_id');
    }
}
