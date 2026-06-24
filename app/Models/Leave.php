<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'type',
        'from_date',
        'to_date',
        'days',
        'reason',
        'status',
        'approver'
    ];
}