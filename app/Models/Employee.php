<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

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

    public function getFormattedSalaryAttribute()
    {
        return 'Rs. ' . number_format($this->salary);
    }

    public function attendances()
    {
        return $this->hasMany(
            Attendance::class,
            'employee_id',
            'id'
        );
    }
}