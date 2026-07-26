<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payroll;
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

        // Monthly attendance trend (last 6 months)
        $months = [];
        $presentData = [];
        $absentData = [];
        $lateData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $label = $date->format('M');
            $monthStart = $date->startOfMonth()->format('Y-m-d');
            $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d');

            $records = Attendance::whereBetween('date', [$monthStart, $monthEnd])
                ->selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            $months[] = $label;
            $presentData[] = (int) ($records['Present'] ?? 0);
            $absentData[] = (int) ($records['Absent'] ?? 0);
            $lateData[] = (int) ($records['Late'] ?? 0);
        }

        // Department distribution
        $deptStats = Employee::selectRaw("department, COUNT(*) as count")
            ->groupBy('department')
            ->pluck('count', 'department');

        // Payroll summary
        $payrollThisMonth = Payroll::where('month', now()->format('Y-m'))
            ->selectRaw("SUM(basic_salary) as total_basic, SUM(allowances) as total_allowances, SUM(deductions) as total_deductions, SUM(net_pay) as total_net")
            ->first();

        return compact(
            'totalEmployees', 'activeEmployees', 'todayAttendance', 'pendingLeaves',
            'months', 'presentData', 'absentData', 'lateData',
            'deptStats', 'payrollThisMonth'
        );
    }

    public function hr()
    {
        return view('CoreSystem.dashboard.hr');
    }

    public function employee()
    {
        return view('CoreSystem.dashboard.employee');
    }
}
