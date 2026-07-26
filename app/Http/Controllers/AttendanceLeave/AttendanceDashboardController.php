<?php

namespace App\Http\Controllers\AttendanceLeave;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\DB;

class AttendanceDashboardController extends Controller
{
    // DASHBOARD
    public function index(Request $request)
    {
        $user = auth()->user();

        // Company Settings
        $settings = CompanySetting::first();
        $monthlyWorkingHours = $settings->monthly_working_hours ?? 205;
        $annualLeaves = $settings->annual_leave_days ?? 12;
        $weeklyHoliday = $settings->weekly_holiday ?? 'Saturday';

        $allEmployees = Employee::all();

        if ($user->isEmployee()) {
            $employee = $user->employee;
            if (!$employee) {
                return view('AttendanceLeave.attendance.index', ['employee' => null]);
            }
            $selectedEmployeeId = $employee->id;
            $employeesForSelect = collect();
        } else {
            // Admin/HR: allow selecting employee via ?employee=X, default to first
            $selectedEmployeeId = $request->integer('employee');
            if (!$selectedEmployeeId || !$allEmployees->contains('id', $selectedEmployeeId)) {
                $selectedEmployeeId = $allEmployees->first()?->id;
            }
            $employee = $allEmployees->firstWhere('id', $selectedEmployeeId);
            $employeesForSelect = $allEmployees;

            if (!$employee) {
                return view('AttendanceLeave.attendance.index', ['employee' => null]);
            }
        }

        // All attendance counts
        $counts = Attendance::where('employee_id', $selectedEmployeeId)
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $present = $counts['Present'] ?? 0;
        $late = $counts['Late'] ?? 0;
        $undertime = $counts['Undertime'] ?? 0;
        $absent = $counts['Absent'] ?? 0;
        $total = $present + $late + $undertime + $absent;
        $rate = $total ? round(($present / $total) * 100) : 0;

        // Current month working hours
        $currentMonthHours = Attendance::where('employee_id', $selectedEmployeeId)
            ->whereBetween('date', [now()->startOfMonth()->format('Y-m-d'), now()->format('Y-m-d')])
            ->sum('working_hours');

        // Monthly chart
        $monthlyRaw = Attendance::where('employee_id', $selectedEmployeeId)
            ->whereBetween('date', [now()->startOfYear()->format('Y-m-d'), now()->format('Y-m-d')])
            ->get(['date', 'status']);

        $monthlyGrouped = $monthlyRaw->groupBy(fn($r) => (int)$r->date->format('m'));
        $monthlyAttendance = [];
        for ($month = 1; $month <= now()->month; $month++) {
            $monthData = $monthlyGrouped->get($month, collect());
            $monthPresent = $monthData->where('status', 'Present')->count();
            $monthTotal = $monthData->count();
            $percentage = $monthTotal ? round(($monthPresent / $monthTotal) * 100) : 0;
            $monthlyAttendance[] = [
                'month' => date('F', mktime(0, 0, 0, $month, 1)),
                'percentage' => $percentage,
            ];
        }

        // Weekly summary
        $weekStart = now()->startOfWeek();
        $weekEnd = $weekStart->copy()->addDays(5);
        $weeklyRecords = Attendance::whereBetween('date', [$weekStart, $weekEnd])
            ->where('status', 'Present')
            ->get(['date', 'employee_id']);

        $weeklyGrouped = $weeklyRecords->groupBy(fn($r) => $r->date->format('Y-m-d'));
        $totalEmployees = Employee::count();
        $weeklySummary = [];
        for ($i = 0; $i < 6; $i++) {
            $dayDate = $weekStart->copy()->addDays($i);
            $presentCount = ($weeklyGrouped->get($dayDate->format('Y-m-d'), collect()))->count();
            $weeklySummary[] = [
                'day' => $dayDate->format('l'),
                'present' => $totalEmployees ? round(($presentCount / $totalEmployees) * 100) : 0,
            ];
        }

        return view('AttendanceLeave.attendance.index', compact(
            'employee', 'employeesForSelect',
            'present', 'late', 'undertime', 'absent', 'rate',
            'monthlyAttendance', 'monthlyWorkingHours', 'annualLeaves',
            'weeklyHoliday', 'currentMonthHours', 'weeklySummary'
        ));
    }
// CREATE PAGE
    public function create()
    {
        $employees = Employee::all();
        return view('AttendanceLeave.attendance.create', compact('employees'));
    }

    // STORE
    public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'status' => 'required|in:Present,Late,Undertime,Absent',
        'date' => 'required|date',
        'check_in' => 'nullable',
        'check_out' => 'nullable',
    ]);

    // prevent duplicate attendance for same employee on same date
    $exists = Attendance::where('employee_id', $request->employee_id)
        ->where('date', $request->date)
        ->exists();

    if ($exists) {
        return back()->withErrors(['date' => 'Attendance already exists for this employee on this date.'])->withInput();
    }

    $workingHours = 0;
    if ($request->check_in && $request->check_out) {
        $checkIn = strtotime($request->check_in);
        $checkOut = strtotime($request->check_out);
        $workingHours = round(($checkOut - $checkIn) / 3600, 2);
    }

    Attendance::create([
        'employee_id' => $request->employee_id,
        'status' => $request->status,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'working_hours' => $workingHours,
    ]);

    return redirect('/attendance?employee=' . $request->employee_id)->with('success', 'Attendance recorded successfully.');
}

    // EDIT PAGE
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();

        return view('AttendanceLeave.attendance.edit', compact('attendance', 'employees'));
    }

    // UPDATE
    public function update(Request $request, $id)
{
    $attendance = Attendance::findOrFail($id);

    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'status' => 'required|in:Present,Late,Undertime,Absent',
        'date' => 'required|date',
        'check_in' => 'nullable',
        'check_out' => 'nullable',
    ]);

    $workingHours = 0;
    if ($request->check_in && $request->check_out) {
        $checkIn = strtotime($request->check_in);
        $checkOut = strtotime($request->check_out);
        $workingHours = round(($checkOut - $checkIn) / 3600, 2);
    }

    $attendance->update([
        'employee_id' => $request->employee_id,
        'status' => $request->status,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'working_hours' => $workingHours,
    ]);

    return redirect('/attendance?employee=' . $request->employee_id)->with('success', 'Attendance updated successfully.');
}

    // DELETE
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employeeId = $attendance->employee_id;
        $attendance->delete();
        return redirect('/attendance?employee=' . $employeeId)->with('success', 'Attendance deleted successfully.');
    }
    

    // REPORT
    public function report()
    {
        $attendances = Attendance::with('employee')->get();

        return view('AttendanceLeave.attendance.report', compact('attendances'));
    }
}
