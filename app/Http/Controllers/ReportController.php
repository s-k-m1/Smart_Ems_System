<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // attendence with dummy data
        $attendanceData = [
            ['id' => 1, 'name' => 'Ram Sharma',   'date' => '2026-06-01', 'status' => 'Present'],
            ['id' => 2, 'name' => 'Sita Rai',     'date' => '2026-06-01', 'status' => 'Absent'],
            ['id' => 3, 'name' => 'Amit Yadav',   'date' => '2026-06-01', 'status' => 'Present'],
            ['id' => 4, 'name' => 'Nisha Karki',  'date' => '2026-06-02', 'status' => 'Leave'],
        ];

        $attendanceEmployees = collect($attendanceData)->pluck('name')->unique()->sort()->values()->all();

        $attendanceSummary = [
            'total'   => count($attendanceData),
            'present' => count(array_filter($attendanceData, fn ($r) => $r['status'] === 'Present')),
            'absent'  => count(array_filter($attendanceData, fn ($r) => $r['status'] === 'Absent')),
            'leave'   => count(array_filter($attendanceData, fn ($r) => $r['status'] === 'Leave')),
        ];
// payrol with dummy data 
        $payrollData = [
            ['id' => 1, 'name' => 'Ram Sharma',   'salary' => 45000, 'status' => 'Paid'],
            ['id' => 2, 'name' => 'Sita Rai',     'salary' => 38000, 'status' => 'Pending'],
            ['id' => 3, 'name' => 'Amit Yadav',   'salary' => 42000, 'status' => 'Paid'],
            ['id' => 4, 'name' => 'Nisha Karki',  'salary' => 50000, 'status' => 'Paid'],
            ['id' => 5, 'name' => 'Bikash Thapa', 'salary' => 36000, 'status' => 'Pending'],
        ];

        $payrollSummary = [
            'total_employees' => count($payrollData),
            'total_payroll'   => array_sum(array_column($payrollData, 'salary')),
            'paid'            => count(array_filter($payrollData, fn ($r) => $r['status'] === 'Paid')),
            'pending'         => count(array_filter($payrollData, fn ($r) => $r['status'] === 'Pending')),
        ];
// employee distribution with dummy data 
        $distributionData = [
            ['id' => 1, 'name' => 'Ram Sharma',   'department' => 'IT',        'designation' => 'Developer'],
            ['id' => 2, 'name' => 'Sita Rai',     'department' => 'HR',        'designation' => 'HR Officer'],
            ['id' => 3, 'name' => 'Amit Yadav',   'department' => 'Finance',   'designation' => 'Accountant'],
            ['id' => 4, 'name' => 'Nisha Karki',  'department' => 'IT',        'designation' => 'QA Engineer'],
            ['id' => 5, 'name' => 'Bikash Thapa', 'department' => 'Sales',     'designation' => 'Sales Executive'],
            ['id' => 6, 'name' => 'Puja Gurung',  'department' => 'Finance',   'designation' => 'Finance Manager'],
            ['id' => 7, 'name' => 'Suresh Magar', 'department' => 'Sales',     'designation' => 'Sales Executive'],
        ];

        $departments = collect($distributionData)->pluck('department')->unique()->sort()->values()->all();

        $distributionSummary = collect($distributionData)
            ->groupBy('department')
            ->map(fn ($rows) => $rows->count())
            ->toArray();

        return view('report', [
            'attendanceData'      => $attendanceData,
            'attendanceEmployees' => $attendanceEmployees,
            'attendanceSummary'   => $attendanceSummary,

            'payrollData'    => $payrollData,
            'payrollSummary' => $payrollSummary,

            'distributionData'    => $distributionData,
            'departments'         => $departments,
            'distributionSummary' => $distributionSummary,
        ]);
    }
}