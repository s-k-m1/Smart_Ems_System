<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_id',
        'name',
        'phone',
        'email',
        'department',
        'position',
        'basic_salary',
    ];

    public function attendances()
    {
        return $this->hasMany(
            Attendance::class,
            'employee_id',
            'id'
        );
    }

    public function payrolls()
    {
        return $this->hasMany(
            Payroll::class,
            'employee_id',
            'id'
        );
    }
}