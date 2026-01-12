<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_npwp',
        'company_address',
        'notification_deadline',
        'deadline_reminder_days',
    ];
}
