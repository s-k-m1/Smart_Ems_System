<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'bonus',
        'unpaid_leave_days',
        'leave_deduction',
        'net_salary',
        'payment_date',
        'status',
    ];
}
