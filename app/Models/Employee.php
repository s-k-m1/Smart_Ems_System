<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'department',
        'position',
        'status',
        'email',
        'phone',
        'joined',
        'address',
        'image',
        'present_days',
        'leave_taken',
        'salary',
        'projects',
    ];

    protected $casts = [
        'joined' => 'date',
    ];

    // Lets us do $employee->formatted_salary in Blade instead of formatting it everywhere.
    public function getFormattedSalaryAttribute()
    {
        return 'Rs. ' . number_format($this->salary);
    }
}