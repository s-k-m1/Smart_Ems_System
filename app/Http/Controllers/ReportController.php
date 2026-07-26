<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // ── Attendance Data ──────────────────────────────────────────
        $attendanceQuery = Attendance::with('employee');
        $attendanceData = $attendanceQuery->get()->map(fn($a) => [
            'id'     => $a->id,
            'name'   => $a->employee->name,
            'date'   => $a->date,
            'status' => $a->status === 'Late' || $a->status === 'Undertime' ? 'Present' : $a->status,
        ])->values()->toArray();

        $attendanceEmployees = collect($attendanceData)->pluck('name')->unique()->sort()->values()->all();

        $attendanceSummary = [
            'total'   => count($attendanceData),
            'present' => count(array_filter($attendanceData, fn($r) => $r['status'] === 'Present')),
            'absent'  => count(array_filter($attendanceData, fn($r) => $r['status'] === 'Absent')),
            'leave'   => count(array_filter($attendanceData, fn($r) => $r['status'] === 'Leave')),
        ];

        // ── Payroll Data ─────────────────────────────────────────────
        $payrollQuery = Payroll::with('employee');
        $payrollData = $payrollQuery->get()->map(fn($p) => [
            'id'     => $p->id,
            'name'   => $p->employee->name,
            'salary' => (float) $p->net_pay,
            'status' => $p->status === 'paid' ? 'Paid' : ($p->status === 'pending' ? 'Pending' : ucfirst($p->status)),
        ])->values()->toArray();

        $payrollSummary = [
            'total_employees' => count($payrollData),
            'total_payroll'   => array_sum(array_column($payrollData, 'salary')),
            'paid'            => count(array_filter($payrollData, fn($r) => $r['status'] === 'Paid')),
            'pending'         => count(array_filter($payrollData, fn($r) => $r['status'] === 'Pending')),
        ];

        // ── Distribution Data ────────────────────────────────────────
        $distributionData = Employee::all()->map(fn($e) => [
            'id'          => $e->id,
            'name'        => $e->name,
            'department'  => $e->department,
            'designation' => $e->position,
        ])->values()->toArray();

        $departments = collect($distributionData)->pluck('department')->unique()->sort()->values()->all();

        return view('report', compact(
            'attendanceData', 'attendanceEmployees', 'attendanceSummary',
            'payrollData', 'payrollSummary',
            'distributionData', 'departments'
        ));
    }
}
