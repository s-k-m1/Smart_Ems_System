<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [

        'title',
        'description',
        'category',
        'department',
        'priority',
        'is_pinned',
        'published_by',
        'publish_date',
        'attachment',
        'status'

    ];

    protected $casts = [

        'publish_date' => 'datetime',

        'is_pinned' => 'boolean',

        'status' => 'boolean'

    ];
}