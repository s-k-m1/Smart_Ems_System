<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';


    protected $fillable = [

        'employee_id',
        'status',
        'date',
        'check_in',
        'check_out',
        'working_hours',
    ];



    /*
    ------------------------
    Attendance
    Belongs To Employee
    ------------------------
    */

    public function employee()
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'id'
        );
    }
}