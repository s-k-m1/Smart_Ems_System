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

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users & Employees ─────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'skycse001@gmail.com'],
            ['name' => 'Admin', 'password' => 'admin@123', 'role' => User::ROLE_ADMIN]
        );

        if ($admin->wasRecentlyCreated) {
            Employee::create([
                'user_id' => $admin->id,
                'employee_id' => 'ADMIN001',
                'name' => 'Admin',
                'department' => 'Management',
                'position' => 'System Administrator',
                'status' => 'Active',
                'email' => 'skycse001@gmail.com',
                'phone' => '555-0000',
                'joined' => '2024-01-01',
                'address' => 'Head Office',
                'present_days' => 25,
                'leave_taken' => 2,
                'salary' => 120000.00,
                'projects' => 5,
            ]);
        }

        $hr = User::firstOrCreate(
            ['email' => 'hr@smartems.com'],
            ['name' => 'HR Manager', 'password' => 'hr@123', 'role' => User::ROLE_HR]
        );

        if ($hr->wasRecentlyCreated) {
            Employee::create([
                'user_id' => $hr->id,
                'employee_id' => 'HR001',
                'name' => 'HR Manager',
                'department' => 'Human Resources',
                'position' => 'HR Manager',
                'status' => 'Active',
                'email' => 'hr@smartems.com',
                'phone' => '555-0101',
                'joined' => '2023-06-15',
                'address' => '456 Oak Ave, City',
                'present_days' => 22,
                'leave_taken' => 3,
                'salary' => 85000.00,
                'projects' => 3,
            ]);
        }

        $empUsers = [];
        $employeeData = [
            ['email' => 'john@smartems.com', 'name' => 'John Doe', 'emp_id' => 'EMP001', 'dept' => 'Engineering', 'pos' => 'Senior Developer', 'phone' => '555-0102', 'joined' => '2023-01-10', 'present' => 24, 'leave' => 1, 'salary' => 95000.00, 'projects' => 6],
            ['email' => 'jane@smartems.com', 'name' => 'Jane Smith', 'emp_id' => 'EMP002', 'dept' => 'Marketing', 'pos' => 'Marketing Lead', 'phone' => '555-0103', 'joined' => '2023-03-20', 'present' => 23, 'leave' => 2, 'salary' => 78000.00, 'projects' => 4],
            ['email' => 'bob@smartems.com', 'name' => 'Bob Wilson', 'emp_id' => 'EMP003', 'dept' => 'Engineering', 'pos' => 'Backend Developer', 'phone' => '555-0104', 'joined' => '2024-02-01', 'present' => 20, 'leave' => 4, 'salary' => 70000.00, 'projects' => 3],
            ['email' => 'alice@smartems.com', 'name' => 'Alice Brown', 'emp_id' => 'EMP004', 'dept' => 'Design', 'pos' => 'UI/UX Designer', 'phone' => '555-0105', 'joined' => '2024-05-10', 'present' => 19, 'leave' => 1, 'salary' => 72000.00, 'projects' => 4],
            ['email' => 'charlie@smartems.com', 'name' => 'Charlie Davis', 'emp_id' => 'EMP005', 'dept' => 'Finance', 'pos' => 'Accountant', 'phone' => '555-0106', 'joined' => '2023-09-01', 'present' => 18, 'leave' => 5, 'salary' => 65000.00, 'projects' => 2],
            ['email' => 'diana@smartems.com', 'name' => 'Diana Evans', 'emp_id' => 'EMP006', 'dept' => 'Engineering', 'pos' => 'Frontend Developer', 'phone' => '555-0107', 'joined' => '2024-07-15', 'present' => 17, 'leave' => 2, 'salary' => 68000.00, 'projects' => 4],
            ['email' => 'frank@smartems.com', 'name' => 'Frank Garcia', 'emp_id' => 'EMP007', 'dept' => 'Sales', 'pos' => 'Sales Executive', 'phone' => '555-0108', 'joined' => '2024-11-20', 'present' => 15, 'leave' => 3, 'salary' => 62000.00, 'projects' => 3],
            ['email' => 'grace@smartems.com', 'name' => 'Grace Harris', 'emp_id' => 'EMP008', 'dept' => 'Human Resources', 'pos' => 'Recruiter', 'phone' => '555-0109', 'joined' => '2025-02-10', 'present' => 14, 'leave' => 1, 'salary' => 58000.00, 'projects' => 1],
            ['email' => 'henry@smartems.com', 'name' => 'Henry Irving', 'emp_id' => 'EMP009', 'dept' => 'Engineering', 'pos' => 'DevOps Engineer', 'phone' => '555-0110', 'joined' => '2025-04-01', 'present' => 12, 'leave' => 2, 'salary' => 82000.00, 'projects' => 3],
            ['email' => 'ivy@smartems.com', 'name' => 'Ivy Johnson', 'emp_id' => 'EMP010', 'dept' => 'Marketing', 'pos' => 'Content Writer', 'phone' => '555-0111', 'joined' => '2025-06-15', 'present' => 10, 'leave' => 0, 'salary' => 55000.00, 'projects' => 2],
        ];

        foreach ($employeeData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => 'pass@123', 'role' => User::ROLE_EMPLOYEE]
            );
            $empUsers[] = $user;

            if ($user->wasRecentlyCreated) {
                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $data['emp_id'],
                    'name' => $data['name'],
                    'department' => $data['dept'],
                    'position' => $data['pos'],
                    'status' => 'Active',
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'joined' => $data['joined'],
                    'address' => '123 Main St, City',
                    'present_days' => $data['present'],
                    'leave_taken' => $data['leave'],
                    'salary' => $data['salary'],
                    'projects' => $data['projects'],
                ]);
            }
        }

        // ── Company Settings ──────────────────────────────────────
        CompanySetting::firstOrCreate(['id' => 1], [
            'company_name' => 'Smart EMS',
            'monthly_working_hours' => 205,
            'annual_leave_days' => 12,
            'weekly_holiday' => 'Saturday',
        ]);

        // ── Attendance (only if table is empty) ───────────────────
        if (Attendance::count() === 0) {
            $allEmployees = Employee::all();
            $statuses = ['Present', 'Present', 'Present', 'Present', 'Late', 'Present', 'Absent', 'Present', 'Present', 'Undertime'];

            for ($monthsBack = 5; $monthsBack >= 0; $monthsBack--) {
                $monthStart = now()->subMonths($monthsBack)->startOfMonth();
                $monthEnd = $monthStart->copy()->endOfMonth()->min(now());

                for ($date = $monthStart->copy(); $date->lte($monthEnd); $date->addDay()) {
                    if ($date->isSaturday() || $date->isSunday()) {
                        continue;
                    }
                    foreach ($allEmployees as $emp) {
                        $status = $statuses[array_rand($statuses)];
                        $checkIn = null;
                        $checkOut = null;
                        $hours = 0;

                        if (in_array($status, ['Present', 'Late', 'Undertime'])) {
                            $checkIn = $status === 'Late' ? '09:30:00' : '08:' . str_pad(rand(30, 55), 2, '0') . ':00';
                            $checkOut = '17:' . str_pad(rand(0, 30), 2, '0') . ':00';
                            $hours = $status === 'Undertime' ? round(6 + rand(0, 10) / 10, 1) : round(8 + rand(0, 5) / 10, 1);
                        }

                        Attendance::create([
                            'employee_id' => $emp->id,
                            'status' => $status,
                            'date' => $date->format('Y-m-d'),
                            'check_in' => $checkIn,
                            'check_out' => $checkOut,
                            'working_hours' => $hours,
                        ]);
                    }
                }
            }
        }

        // ── Leaves (only if table is empty) ───────────────────────
        if (Leave::count() === 0) {
            $allEmployees = Employee::all();
            $leaveTypes = ['Annual', 'Sick', 'Personal', 'Other'];
            $leaveReasons = [
                'Annual' => 'Annual vacation planned for this period',
                'Sick' => 'Medical leave advised by physician',
                'Personal' => 'Personal family matter to attend to',
                'Other' => 'Leave requested for personal reasons',
            ];

            foreach ($allEmployees as $emp) {
                $numLeaves = rand(2, 5);
                for ($i = 0; $i < $numLeaves; $i++) {
                    $type = $leaveTypes[array_rand($leaveTypes)];
                    $from = now()->subDays(rand(1, 90))->startOfDay();
                    $to = $from->copy()->addDays(rand(1, 4));
                    $days = (int) $from->diffInDays($to) + 1;
                    Leave::create([
                        'employee_id' => $emp->id,
                        'type' => $type,
                        'from_date' => $from->format('Y-m-d'),
                        'to_date' => $to->format('Y-m-d'),
                        'days' => $days,
                        'status' => ['Pending', 'Approved', 'Approved', 'Approved', 'Rejected'][array_rand([0, 1, 1, 1, 2])],
                        'reason' => $leaveReasons[$type],
                        'approver' => 'HR Manager',
                    ]);
                }
            }
        }

        // ── Notifications (only if table is empty) ────────────────
        if (Notification::count() === 0) {
            $notifications = [
                ['title' => 'Annual Leave Policy Update', 'description' => 'The annual leave policy has been updated. Please review the new changes in the employee handbook.', 'category' => 'Policies', 'priority' => 'High', 'is_pinned' => true, 'published_by' => 'HR Manager'],
                ['title' => 'Company Holiday Schedule', 'description' => 'The holiday schedule for the upcoming quarter has been released. Please check the company calendar for details.', 'category' => 'Company', 'priority' => 'Medium', 'is_pinned' => false, 'published_by' => 'Administrator'],
                ['title' => 'Payroll Processing Notice', 'description' => 'Payroll for this month will be processed on the 28th. Please ensure all timesheets are submitted by the 25th.', 'category' => 'Payroll', 'priority' => 'High', 'is_pinned' => true, 'published_by' => 'Finance Department'],
                ['title' => 'Team Building Event', 'description' => 'We are organizing a team building event next Friday. Please confirm your attendance with HR.', 'category' => 'Events', 'priority' => 'Low', 'is_pinned' => false, 'published_by' => 'HR Manager'],
                ['title' => 'New Training Program', 'description' => 'A new training program on Leadership Skills is now available. Interested employees can register through the HR portal.', 'category' => 'Training', 'priority' => 'Medium', 'is_pinned' => false, 'published_by' => 'Training Department'],
                ['title' => 'Office Renovation Notice', 'description' => 'The 2nd floor will undergo renovation from next month. Please coordinate with your managers for temporary seating arrangements.', 'category' => 'Company', 'priority' => 'Medium', 'is_pinned' => false, 'published_by' => 'Administrator'],
                ['title' => 'Quarterly Performance Review', 'description' => 'Quarterly performance reviews will begin next week. Please prepare your self-assessment documents.', 'category' => 'Policies', 'priority' => 'High', 'is_pinned' => true, 'published_by' => 'HR Manager'],
            ];

            foreach ($notifications as $i => $note) {
                Notification::create([
                    'title' => $note['title'],
                    'description' => $note['description'],
                    'category' => $note['category'],
                    'department' => 'All Departments',
                    'priority' => $note['priority'],
                    'is_pinned' => $note['is_pinned'],
                    'published_by' => $note['published_by'],
                    'publish_date' => now()->subDays(7 - $i),
                ]);
            }
        }

        // ── Payroll (only if table is empty) ──────────────────────
        if (Payroll::count() === 0) {
            $allEmployees = Employee::all();
            for ($m = 2; $m >= 0; $m--) {
                $month = now()->subMonths($m)->format('Y-m');
                foreach ($allEmployees as $emp) {
                    $basic = $emp->salary;
                    $allowances = round($basic * 0.2, 2);
                    $deductions = round($basic * 0.05, 2);
                    Payroll::create([
                        'employee_id' => $emp->id,
                        'month' => $month,
                        'basic_salary' => $basic,
                        'allowances' => $allowances,
                        'deductions' => $deductions,
                        'net_pay' => $basic + $allowances - $deductions,
                        'status' => $m === 0 ? 'pending' : 'paid',
                        'payment_date' => $m === 0 ? null : now()->subMonths($m)->subDays(rand(1, 15)),
                    ]);
                }
            }
        }

        $this->command->info('Seed data loaded successfully');
        $this->command->info('Admin: skycse001@gmail.com / admin@123');
        $this->command->info('HR: hr@smartems.com / hr@123');
        $this->command->info('Employees: john,jane,bob,alice,charlie,diana,frank,grace,henry,ivy @smartems.com / pass@123');
    }
}
