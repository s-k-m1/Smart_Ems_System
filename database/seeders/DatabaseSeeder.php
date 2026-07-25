<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\CompanySetting;
use App\Models\Notification;
use App\Models\Payroll;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────────
        $admin = User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $hr = User::factory()->create([
            'name'     => 'HR User',
            'email'    => 'hr@example.com',
            'password' => bcrypt('password'),
            'role'     => 'hr',
        ]);

        $employeeUser = User::factory()->create([
            'name'     => 'Employee User',
            'email'    => 'employee@example.com',
            'password' => bcrypt('password'),
            'role'     => 'employee',
        ]);

        // Extra employees for richer data
        $emp2 = User::factory()->create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => bcrypt('password'),
            'role'     => 'employee',
        ]);

        $emp3 = User::factory()->create([
            'name'     => 'Jane Smith',
            'email'    => 'jane@example.com',
            'password' => bcrypt('password'),
            'role'     => 'employee',
        ]);

        // ── Employees ─────────────────────────────────────────────
        $e1 = Employee::create([
            'user_id'      => $employeeUser->id,
            'employee_id'  => 'EMP001',
            'name'         => 'Employee User',
            'department'   => 'Engineering',
            'position'     => 'Software Developer',
            'status'       => 'Active',
            'email'        => 'employee@example.com',
            'phone'        => '555-0101',
            'joined'       => '2024-01-15',
            'address'      => '123 Main St, City',
            'present_days' => 22,
            'leave_taken'  => 2,
            'salary'       => 60000.00,
            'projects'     => 3,
        ]);

        $e2 = Employee::create([
            'user_id'      => $emp2->id,
            'employee_id'  => 'EMP002',
            'name'         => 'John Doe',
            'department'   => 'Engineering',
            'position'     => 'Senior Developer',
            'status'       => 'Active',
            'email'        => 'john@example.com',
            'phone'        => '555-0102',
            'joined'       => '2023-06-01',
            'address'      => '456 Oak Ave, City',
            'present_days' => 20,
            'leave_taken'  => 3,
            'salary'       => 85000.00,
            'projects'     => 5,
        ]);

        $e3 = Employee::create([
            'user_id'      => $emp3->id,
            'employee_id'  => 'EMP003',
            'name'         => 'Jane Smith',
            'department'   => 'Marketing',
            'position'     => 'Marketing Lead',
            'status'       => 'Active',
            'email'        => 'jane@example.com',
            'phone'        => '555-0103',
            'joined'       => '2024-03-10',
            'address'      => '789 Pine Rd, City',
            'present_days' => 18,
            'leave_taken'  => 1,
            'salary'       => 70000.00,
            'projects'     => 4,
        ]);

        $e4 = Employee::create([
            'user_id'      => $hr->id,
            'employee_id'  => 'EMP004',
            'name'         => 'HR User',
            'department'   => 'Human Resources',
            'position'     => 'HR Manager',
            'status'       => 'Active',
            'email'        => 'hr@example.com',
            'phone'        => '555-0104',
            'joined'       => '2022-11-20',
            'address'      => '321 Elm St, City',
            'present_days' => 21,
            'leave_taken'  => 4,
            'salary'       => 75000.00,
            'projects'     => 2,
        ]);

        // ── Attendance (last 30 days for each employee) ──────────
        $statuses   = ['Present', 'Present', 'Present', 'Present', 'Late', 'Present', 'Absent', 'Present', 'Present', 'Undertime'];
        $employees  = [$e1, $e2, $e3, $e4];
        $start      = now()->subDays(29);

        for ($day = 0; $day < 30; $day++) {
            $date = $start->copy()->addDays($day);
            if ($date->isSaturday()) {
                continue;
            }
            foreach ($employees as $emp) {
                $status = $statuses[array_rand($statuses)];
                $checkIn  = null;
                $checkOut = null;
                $hours    = 0;

                if (in_array($status, ['Present', 'Late', 'Undertime'])) {
                    $checkIn  = $status === 'Late' ? '09:30:00' : '08:45:00';
                    $checkOut = '17:00:00';
                    $hours    = $status === 'Undertime' ? 6.5 : 8.0;
                }

                Attendance::create([
                    'employee_id'   => $emp->id,
                    'status'        => $status,
                    'date'          => $date->format('Y-m-d'),
                    'check_in'      => $checkIn,
                    'check_out'     => $checkOut,
                    'working_hours' => $hours,
                ]);
            }
        }

        // ── Leaves ────────────────────────────────────────────────
        Leave::create([
            'employee_id' => $e1->id,
            'type'        => 'Annual',
            'from_date'   => '2025-07-10',
            'to_date'     => '2025-07-12',
            'days'        => 3,
            'reason'      => 'Family vacation',
            'status'      => 'Approved',
            'approver'    => 'HR User',
        ]);

        Leave::create([
            'employee_id' => $e2->id,
            'type'        => 'Sick',
            'from_date'   => '2025-07-15',
            'to_date'     => '2025-07-15',
            'days'        => 1,
            'reason'      => 'Doctor appointment',
            'status'      => 'Approved',
            'approver'    => 'HR User',
        ]);

        Leave::create([
            'employee_id' => $e3->id,
            'type'        => 'Casual',
            'from_date'   => '2025-07-20',
            'to_date'     => '2025-07-21',
            'days'        => 2,
            'reason'      => 'Personal errand',
            'status'      => 'Pending',
            'approver'    => null,
        ]);

        Leave::create([
            'employee_id' => $e4->id,
            'type'        => 'Annual',
            'from_date'   => '2025-08-01',
            'to_date'     => '2025-08-05',
            'days'        => 5,
            'reason'      => 'Annual leave',
            'status'      => 'Pending',
            'approver'    => null,
        ]);

        // ── Company Settings ──────────────────────────────────────
        CompanySetting::create([
            'monthly_working_hours' => 205,
            'annual_leave_days'     => 12,
            'weekly_holiday'        => 'Saturday',
        ]);

        // ── Notifications ─────────────────────────────────────────
        Notification::create([
            'title'        => 'Welcome to Smart EMS',
            'description'  => 'The Employee Management System is now live. Please explore the dashboard and update your profile.',
            'category'     => 'General',
            'department'   => null,
            'priority'     => 'High',
            'is_pinned'    => true,
            'published_by' => 'Admin User',
            'publish_date' => now(),
            'status'       => true,
        ]);

        Notification::create([
            'title'        => 'New Payroll Schedule',
            'description'  => 'Payroll for July will be processed on the 28th. Please ensure all timesheets are submitted by the 25th.',
            'category'     => 'Payroll',
            'department'   => null,
            'priority'     => 'Medium',
            'is_pinned'    => false,
            'published_by' => 'HR User',
            'publish_date' => now()->subDays(1),
            'status'       => true,
        ]);

        Notification::create([
            'title'        => 'Office Closure Notice',
            'description'  => 'The office will remain closed on August 15th for Independence Day. Please plan accordingly.',
            'category'     => 'Holiday',
            'department'   => null,
            'priority'     => 'Low',
            'is_pinned'    => false,
            'published_by' => 'Admin User',
            'publish_date' => now()->subDays(2),
            'status'       => true,
        ]);

        Notification::create([
            'title'        => 'Engineering Team Meeting',
            'description'  => 'Sprint planning meeting this Friday at 10 AM in Conference Room B. All engineering staff must attend.',
            'category'     => 'Meeting',
            'department'   => 'Engineering',
            'priority'     => 'High',
            'is_pinned'    => true,
            'published_by' => 'Admin User',
            'publish_date' => now()->subDays(3),
            'status'       => true,
        ]);

        Notification::create([
            'title'        => 'Quarterly Review Reminder',
            'description'  => 'Managers are reminded to complete quarterly performance reviews by the end of this month.',
            'category'     => 'HR',
            'department'   => 'Human Resources',
            'priority'     => 'Medium',
            'is_pinned'    => false,
            'published_by' => 'HR User',
            'publish_date' => now()->subDays(5),
            'status'       => true,
        ]);

        // ── Payroll ────────────────────────────────────────────────
        $months = ['2025-06', '2025-07'];
        foreach ($employees as $emp) {
            foreach ($months as $month) {
                $basic = $emp->salary;
                $allowances = $basic * 0.1;
                $deductions = $basic * 0.05;
                $net = $basic + $allowances - $deductions;
                Payroll::create([
                    'employee_id'  => $emp->id,
                    'month'        => $month,
                    'basic_salary' => $basic,
                    'allowances'   => $allowances,
                    'deductions'   => $deductions,
                    'net_pay'      => $net,
                    'payment_date' => $month === '2025-06' ? now()->subDays(20) : null,
                    'status'       => $month === '2025-06' ? 'paid' : 'pending',
                    'notes'        => $month === '2025-06' ? 'Processed on time' : null,
                ]);
            }
        }
    }
}
