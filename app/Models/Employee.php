<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
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

    protected function casts(): array
    {
        return [
            'joined' => 'date:Y-m-d',
            'salary' => 'decimal:2',
        ];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedSalaryAttribute(): string
    {
        return 'Rs. ' . number_format($this->salary, 2);
    }
}
