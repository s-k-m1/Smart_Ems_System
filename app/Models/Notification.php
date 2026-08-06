<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'status',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'is_pinned' => 'boolean',
        'status' => 'boolean',
    ];

    public function readByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_user')
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }

    public function markAsRead(User $user): void
    {
        \DB::table('notification_user')
            ->updateOrInsert(
                ['notification_id' => $this->id, 'user_id' => $user->id],
                ['is_read' => true, 'read_at' => now(), 'updated_at' => now()]
            );
    }

    public function isReadBy(User $user): bool
    {
        return $this->readByUsers()
            ->wherePivot('is_read', true)
            ->where('user_id', $user->id)
            ->exists();
    }
}
