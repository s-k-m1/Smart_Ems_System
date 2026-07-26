<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'skycse001@gmail.com'],
            [
                'name' => 'Admin',
                'password' => 'admin@123',
                'role' => User::ROLE_ADMIN,
            ]
        );

        if ($user->wasRecentlyCreated) {
            Employee::create([
                'user_id' => $user->id,
                'employee_id' => 'ADMIN001',
                'name' => 'Admin',
                'department' => 'Management',
                'position' => 'System Administrator',
                'status' => 'Active',
                'email' => 'skycse001@gmail.com',
                'phone' => '555-0000',
                'joined' => now()->format('Y-m-d'),
                'address' => 'Head Office',
            ]);
        }

        $this->command->info('Admin user created: skycse001@gmail.com / admin@123');
    }
}
