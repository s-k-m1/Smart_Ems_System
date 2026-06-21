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

        'department'
    ];

    public function attendances()
    {
        return $this->hasMany(
            Attendance::class,
            'employee_id',
            'id'
        );
    }
}