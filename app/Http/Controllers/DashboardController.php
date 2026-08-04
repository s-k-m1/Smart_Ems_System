<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('CoreSystem.dashboard.index');
    }

    public function admin()
    {
        $data = $this->buildDashboardData();
        return view('CoreSystem.dashboard.admin', $data);
    }

    public function chartData()
    {
        return response()->json($this->buildDashboardData());
    }

    private function buildDashboardData()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'Active')->count();
        $todayAttendance = Attendance::whereDate('date', now()->toDateString())->count();
        $pendingLeaves = Leave::where('status', 'Pending')->count();

        // Monthly attendance trend + working hours (last 6 months)
        $months = [];
        $presentData = [];
        $absentData = [];
        $lateData = [];
        $workingHoursData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $label = $date->format('M');
            $monthStart = $date->startOfMonth()->format('Y-m-d');
            $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d');
            $monthEndFormatted = $date->format('Y-m');

            $records = Attendance::whereBetween('date', [$monthStart, $monthEnd])
                ->selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            $monthHours = Attendance::whereBetween('date', [$monthStart, $monthEnd])
                ->sum('working_hours');

            $months[] = $label;
            $presentData[] = (int) ($records['Present'] ?? 0);
            $absentData[] = (int) ($records['Absent'] ?? 0);
            $lateData[] = (int) ($records['Late'] ?? 0);
            $workingHoursData[] = round($monthHours, 1);
        }

        // Department distribution
        $deptStats = Employee::selectRaw("department, COUNT(*) as count")
            ->groupBy('department')
            ->pluck('count', 'department');

        return compact(
            'totalEmployees', 'activeEmployees', 'todayAttendance', 'pendingLeaves',
            'months', 'presentData', 'absentData', 'lateData', 'workingHoursData',
            'deptStats'
        );
    }

    public function hr()
    {
        $data = $this->buildHrData();

        return view('CoreSystem.dashboard.hr', $data);
    }

    public function hrChartData()
    {
        return response()->json($this->buildHrData());
    }

    private function buildHrData()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'Active')->count();
        $todayAttendance = Attendance::whereDate('date', now()->toDateString())->count();
        $absentToday = Employee::where('status', 'Active')->count() - $todayAttendance;
        $pendingLeaves = Leave::where('status', 'Pending')->count();

        $pendingLeaveList = Leave::with('employee')
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $months = [];
        $presentData = [];
        $absentData = [];
        $lateData = [];
        $workingHoursData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->startOfMonth()->format('Y-m-d');
            $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d');

            $records = Attendance::whereBetween('date', [$monthStart, $monthEnd])
                ->selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            $months[] = $date->format('M');
            $presentData[] = (int) ($records['Present'] ?? 0);
            $absentData[] = (int) ($records['Absent'] ?? 0);
            $lateData[] = (int) ($records['Late'] ?? 0) + (int) ($records['Undertime'] ?? 0);
            $workingHoursData[] = round(Attendance::whereBetween('date', [$monthStart, $monthEnd])->sum('working_hours'), 1);
        }

        $deptStats = Employee::selectRaw("department, COUNT(*) as count")
            ->groupBy('department')
            ->pluck('count', 'department');

        return compact(
            'totalEmployees', 'activeEmployees', 'todayAttendance', 'absentToday', 'pendingLeaves',
            'pendingLeaveList', 'months', 'presentData', 'absentData', 'lateData',
            'workingHoursData', 'deptStats'
        );
    }

    public function employee()
    {
        $employee = auth()->user()->employee;

        if (!$employee) {
            return view('CoreSystem.dashboard.employee', compact('employee'));
        }

        // Present days this month (Present/Late/Undertime = attended)
        $presentDays = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [now()->startOfMonth()->format('Y-m-d'), now()->format('Y-m-d')])
            ->whereIn('status', ['Present', 'Late', 'Undertime'])
            ->count();

        // Approved leave days taken
        $leaveTaken = Leave::where('employee_id', $employee->id)
            ->where('status', 'Approved')
            ->sum('days');

        // Pending leave applications
        $pendingLeaves = Leave::where('employee_id', $employee->id)
            ->where('status', 'Pending')
            ->count();

        // Working hours this month
        $workingHours = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [now()->startOfMonth()->format('Y-m-d'), now()->format('Y-m-d')])
            ->sum('working_hours');

        // Attendance rate this year
        $yearCounts = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [now()->startOfYear()->format('Y-m-d'), now()->format('Y-m-d')])
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $yearTotal = array_sum($yearCounts->all());
        $yearPresent = ($yearCounts['Present'] ?? 0) + ($yearCounts['Late'] ?? 0) + ($yearCounts['Undertime'] ?? 0);
        $attendanceRate = $yearTotal ? round(($yearPresent / $yearTotal) * 100) : 0;

        // Personal monthly trend (last 6 months)
        $months = [];
        $presentData = [];
        $absentData = [];
        $lateData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $records = Attendance::where('employee_id', $employee->id)
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            $months[] = $date->format('M');
            $presentData[] = (int) ($records['Present'] ?? 0) + (int) ($records['Late'] ?? 0) + (int) ($records['Undertime'] ?? 0);
            $absentData[] = (int) ($records['Absent'] ?? 0);
            $lateData[] = (int) ($records['Late'] ?? 0);
        }

        $recentAttendance = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('CoreSystem.dashboard.employee', compact(
            'employee', 'presentDays', 'leaveTaken', 'pendingLeaves', 'workingHours',
            'attendanceRate', 'months', 'presentData', 'absentData', 'lateData', 'recentAttendance'
        ));
    }
}
