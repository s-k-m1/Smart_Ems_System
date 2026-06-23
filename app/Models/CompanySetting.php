<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'monthly_working_hours',
        'annual_leave_days',
        'weekly_holiday'
    ];
}
