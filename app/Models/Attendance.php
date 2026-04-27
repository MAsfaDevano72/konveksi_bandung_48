<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id', 
        'date', 
        'status', 
        'overtime_hours', 
        'note'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
