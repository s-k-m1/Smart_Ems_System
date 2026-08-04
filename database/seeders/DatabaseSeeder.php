<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\CompanySetting;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('attendances')->delete();
        \Illuminate\Support\Facades\DB::table('leaves')->delete();
        \Illuminate\Support\Facades\DB::table('notifications')->delete();

        mt_srand(20260804);

        // ── Users & Employees ─────────────────────────────────────
        $people = [
            ['email' => 'admin@example.com',   'name' => 'Admin User',     'role' => 'admin', null],
            ['email' => 'hr@example.com',      'name' => 'HR User',        'role' => 'hr', 'EMP004', 'Human Resources', 'HR Manager', '2022-11-20', 75000.00],
            ['email' => 'employee@example.com','name' => 'Employee User',  'role' => 'employee', 'EMP001', 'Engineering', 'Software Developer', '2024-01-15', 60000.00],
            ['email' => 'john@example.com',    'name' => 'John Doe',       'role' => 'employee', 'EMP002', 'Engineering', 'Senior Developer', '2023-06-01', 85000.00],
            ['email' => 'jane@example.com',    'name' => 'Jane Smith',     'role' => 'employee', 'EMP003', 'Marketing', 'Marketing Lead', '2024-03-10', 70000.00],
            ['email' => 'skycse001@gmail.com', 'name' => 'saroj',          'role' => 'employee', 'EMP005', 'Engineering', 'Software Developer', '2024-01-15', 60000.00],
            ['email' => 'bob@example.com',     'name' => 'Bob Wilson',     'role' => 'employee', 'EMP006', 'Engineering', 'Backend Developer', '2024-02-01', 70000.00],
            ['email' => 'alice@example.com',   'name' => 'Alice Brown',    'role' => 'employee', 'EMP007', 'Design', 'UI/UX Designer', '2024-05-10', 72000.00],
            ['email' => 'charlie@example.com', 'name' => 'Charlie Davis',  'role' => 'employee', 'EMP008', 'Finance', 'Accountant', '2023-09-01', 65000.00],
            ['email' => 'diana@example.com',   'name' => 'Diana Evans',    'role' => 'employee', 'EMP009', 'Engineering', 'Frontend Developer', '2024-07-15', 68000.00],
            ['email' => 'frank@example.com',   'name' => 'Frank Garcia',   'role' => 'employee', 'EMP010', 'Sales', 'Sales Executive', '2024-11-20', 62000.00],
            ['email' => 'grace@example.com',   'name' => 'Grace Harris',   'role' => 'employee', 'EMP011', 'Human Resources', 'Recruiter', '2025-02-10', 58000.00],
            ['email' => 'henry@example.com',   'name' => 'Henry Irving',   'role' => 'employee', 'EMP012', 'Engineering', 'DevOps Engineer', '2025-04-01', 82000.00],
            ['email' => 'ivy@example.com',     'name' => 'Ivy Johnson',    'role' => 'employee', 'EMP013', 'Marketing', 'Content Writer', '2025-06-15', 55000.00],
        ];

        foreach ($people as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                ['name' => $p['name'], 'password' => bcrypt('password'), 'role' => $p['role']]
            );

            if (($p[0] ?? null) === null) {
                continue;
            }

            $emp = Employee::firstOrCreate(
                ['employee_id' => $p[0]],
                [
                    'user_id'      => $user->id,
                    'employee_id'  => $p[0],
                    'name'         => $p['name'],
                    'department'   => $p[1],
                    'position'     => $p[2],
                    'status'       => 'Active',
                    'email'        => $p['email'],
                    'phone'        => '555-01' . str_pad((string) mt_rand(50, 99), 2, '0'),
                    'joined'       => $p[3],
                    'address'      => 'Test Address, Kathmandu',
                    'present_days' => 0,
                    'leave_taken'  => 0,
                    'salary'       => $p[4],
                    'projects'     => mt_rand(1, 5),
                ]
            );
        }

        // ── Attendance (last 6 months, Saturdays off) ─────────────
        $weights = ['Present', 'Present', 'Present', 'Present', 'Present', 'Late', 'Late', 'Present', 'Undertime', 'Present', 'Absent', 'Present', 'Late', 'Present', 'Absent'];
        $allEmployees = Employee::all();
        $start = now()->subMonths(5)->startOfMonth();
        $end = now()->copy()->subDay();

        foreach ($allEmployees as $emp) {
            $presentCount = 0;
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if ($date->isSaturday()) {
                    continue;
                }

                $status = $weights[array_rand($weights)];
                $checkIn  = null;
                $checkOut = null;
                $hours    = 0.00;

                if (in_array($status, ['Present', 'Late', 'Undertime'])) {
                    if ($status === 'Late') {
                        $checkIn  = '09:' . str_pad((string) mt_rand(20, 55), 2, '0') . ':00';
                        $checkOut = '17:' . str_pad((string) mt_rand(0, 30), 2, '0', STR_PAD_LEFT) . ':00';
                        $hours    = round(7.5 + mt_rand(0, 5) / 10, 1);
                    } elseif ($status === 'Undertime') {
                        $checkIn  = '08:' . str_pad((string) mt_rand(40, 55), 2, '0') . ':00';
                        $checkOut = '15:' . str_pad((string) mt_rand(0, 30), 2, '0', STR_PAD_LEFT) . ':00';
                        $hours    = round(5.5 + mt_rand(0, 10) / 10, 1);
                    } else {
                        $checkIn  = '08:' . str_pad((string) mt_rand(30, 55), 2, '0') . ':00';
                        $checkOut = '17:' . str_pad((string) mt_rand(0, 30), 2, '0', STR_PAD_LEFT) . ':00';
                        $hours    = round(8.0 + mt_rand(0, 5) / 10, 1);
                    }
                    $presentCount++;
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

            $emp->present_days = $presentCount;
            $emp->save();
        }

        // ── Leaves ────────────────────────────────────────────────
        $types = ['Annual', 'Sick', 'Casual'];
        $reasons = [
            'Annual' => 'Annual vacation planned for this period',
            'Sick'   => 'Medical leave advised by physician',
            'Casual' => 'Personal family matter to attend to',
        ];
        $statusPool = ['Approved', 'Approved', 'Approved', 'Pending', 'Rejected'];

        foreach ($allEmployees as $emp) {
            $num = mt_rand(2, 4);
            $leaveTaken = 0;

            for ($i = 0; $i < $num; $i++) {
                $type  = $types[array_rand($types)];
                $status = $statusPool[array_rand($statusPool)];
                $recent = ($i === 0 && mt_rand(0, 1) === 1)
                    ? mt_rand(1, abs(now()->diffInDays($start)) + 1)
                    : mt_rand(1, 170);
                $from = now()->subDays($recent)->startOfDay();
                $days = mt_rand(1, 5);
                $to   = $from->copy()->addDays($days - 1);

                if ($status === 'Approved') {
                    $leaveTaken += $days;
                }

                Leave::create([
                    'employee_id' => $emp->id,
                    'type'        => $type,
                    'from_date'   => $from->format('Y-m-d'),
                    'to_date'     => $to->format('Y-m-d'),
                    'days'        => $days,
                    'reason'      => $reasons[$type],
                    'status'      => $status,
                    'approver'    => $status === 'Pending' ? null : 'HR User',
                    'created_at'  => $from,
                    'updated_at'  => now(),
                ]);
            }

            $emp->leave_taken = $leaveTaken;
            $emp->save();
        }

        // ── Notifications ─────────────────────────────────────────
        $notifications = [
            ['Welcome to Smart EMS', 'The Employee Management System is now live. Please explore the dashboard and complete your profile.', 'General',  null, 'High', true,  'Admin User', 30],
            ['Office Closure for Independence Day', 'The office will be closed on August 15th. Please plan your work accordingly.', 'Holiday', null, 'Low', false, 'Admin User', 12],
            ['Sprint Planning Meeting', 'Engineering sprint planning this Friday at 10 AM in Conference Room B.', 'Meeting',  'Engineering', 'High', true, 'Admin User', 5],
            ['Quarterly Review Reminder', 'Managers must complete quarterly performance reviews by the end of this month.', 'HR', 'Human Resources', 'Medium', false, 'HR User', 8],
            ['New Health Insurance Policy', 'The updated health insurance policy is now effective. Review the details on the HR portal.', 'Policies', null, 'Medium', false, 'HR User', 15],
            ['Leadership Training Program', 'A new training program on Leadership Skills is available. Register through the HR portal.', 'Training', null, 'Medium', false, 'HR User', 6],
            ['Annual Team Building Event', 'Annual team building event scheduled for next month. Confirm your attendance with HR.', 'Events',  null, 'Low', false, 'HR User', 3],
            ['Company Town Hall', 'The quarterly town hall will be held at the main auditorium. All employees must attend.', 'Company', null, 'Medium', true, 'Admin User', 1],
        ];

        foreach ($notifications as $idx => $n) {
            Notification::create([
                'title'        => $n[0],
                'description'  => $n[1],
                'category'     => $n[2],
                'department'   => $n[3],
                'priority'     => $n[4],
                'is_pinned'    => $n[5],
                'published_by' => $n[6],
                'publish_date' => now()->subDays($n[7]),
                'status'       => true,
            ]);
        }

        // ── Company Settings ──────────────────────────────────────
        CompanySetting::firstOrCreate(['id' => 1], [
            'monthly_working_hours' => 205,
            'annual_leave_days'     => 12,
            'weekly_holiday'        => 'Saturday',
        ]);

        // ── Permissions ──────────────────────────────────────────
        $this->seedPermissions();

        $this->command->info('Database seeded with test data.');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('HR: hr@example.com / password');
        $this->command->info('Employees: employee,john,jane,skycse001@gmail.com,bob,alice,charlie,diana,frank,grace,henry,ivy @example.com / password');
    }

    private function seedPermissions(): void
    {
        \Illuminate\Support\Facades\DB::table('permissions')->delete();
        \Illuminate\Support\Facades\DB::table('role_permissions')->delete();

        $permissions = [
            ['name' => 'view_dashboard', 'label' => 'View Dashboard', 'group' => 'general'],
            ['name' => 'manage_employees', 'label' => 'Manage Employees', 'group' => 'employees'],
            ['name' => 'view_employees', 'label' => 'View Employees', 'group' => 'employees'],
            ['name' => 'manage_attendance', 'label' => 'Manage Attendance', 'group' => 'attendance'],
            ['name' => 'view_attendance', 'label' => 'View Attendance', 'group' => 'attendance'],
            ['name' => 'manage_leave', 'label' => 'Manage Leave', 'group' => 'leave'],
            ['name' => 'view_leave', 'label' => 'View Leave', 'group' => 'leave'],
            ['name' => 'manage_notifications', 'label' => 'Manage Notifications', 'group' => 'notifications'],
            ['name' => 'view_notifications', 'label' => 'View Notifications', 'group' => 'notifications'],
            ['name' => 'manage_payroll', 'label' => 'Manage Payroll', 'group' => 'payroll'],
            ['name' => 'view_payroll', 'label' => 'View Payroll', 'group' => 'payroll'],
            ['name' => 'manage_reports', 'label' => 'Manage Reports', 'group' => 'reports'],
            ['name' => 'view_reports', 'label' => 'View Reports', 'group' => 'reports'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        $allPermissionIds = Permission::pluck('id', 'name');

        $rolePermissions = [
            'admin' => array_keys($allPermissionIds->toArray()),
            'hr' => [
                'view_dashboard', 'view_employees', 'manage_employees',
                'view_attendance', 'manage_attendance',
                'view_leave', 'manage_leave',
                'view_notifications', 'manage_notifications',
                'view_payroll', 'manage_payroll',
                'view_reports',
            ],
            'employee' => [
                'view_dashboard', 'view_employees',
                'view_attendance', 'manage_attendance',
                'view_leave', 'manage_leave',
                'view_notifications',
            ],
        ];

        foreach ($rolePermissions as $role => $permNames) {
            foreach ($permNames as $permName) {
                $permId = $allPermissionIds[$permName] ?? null;
                if ($permId) {
                    \DB::table('role_permissions')->updateOrInsert(
                        ['role' => $role, 'permission_id' => $permId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }
        }
    }
}