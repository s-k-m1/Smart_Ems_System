<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'theme'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_HR = 'hr';
    const ROLE_EMPLOYEE = 'employee';

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isHr(): bool
    {
        return $this->role === self::ROLE_HR;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return \Illuminate\Support\Facades\DB::table('role_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->where('role_permissions.role', $this->role)
            ->where('permissions.name', $permission)
            ->exists();
    }

    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return \Illuminate\Support\Facades\DB::table('role_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->where('role_permissions.role', $this->role)
            ->whereIn('permissions.name', $permissions)
            ->exists();
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PasswordReset($token));
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function notificationsRead()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }

    public function unreadNotificationsCount(): int
    {
        $query = Notification::query()
            ->whereDoesntHave('readByUsers', function ($q) {
                $q->where('user_id', $this->id)
                  ->where('is_read', true);
            });

        if ($this->isEmployee()) {
            $employee = $this->employee;
            $query->where(function ($q) use ($employee) {
                $q->whereNull('department')
                  ->orWhere('department', '');
                if ($employee) {
                    $q->orWhere('department', $employee->department);
                }
            });
        }

        return $query->count();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
