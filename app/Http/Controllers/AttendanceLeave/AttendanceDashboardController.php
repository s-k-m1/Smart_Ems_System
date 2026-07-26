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
    public function index()
    {
        $user = auth()->user();

        $employeeId = null;

        if ($user->isEmployee()) {
            $employee = Employee::where('user_id', $user->id)->first();
            if (!$employee) {
                return view('AttendanceLeave.attendance.index', ['employee' => null]);
            }
            $employeeId = $employee->id;
        } else {
            $employee = Employee::first();
            if (!$employee) {
                return view('AttendanceLeave.attendance.index', ['employee' => null]);
            }
            $employeeId = $employee->id;
        }

        // Company Settings (cached in memory for the request)
        $settings = CompanySetting::first();
        $monthlyWorkingHours = $settings->monthly_working_hours ?? 205;
        $annualLeaves = $settings->annual_leave_days ?? 12;
        $weeklyHoliday = $settings->weekly_holiday ?? 'Saturday';

        // All attendance counts in ONE query with GROUP BY
        $counts = Attendance::where('employee_id', $employeeId)
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $present = $counts['Present'] ?? 0;
        $late = $counts['Late'] ?? 0;
        $undertime = $counts['Undertime'] ?? 0;
        $absent = $counts['Absent'] ?? 0;
        $total = $present + $late + $undertime + $absent;
        $rate = $total ? round(($present / $total) * 100) : 0;

        // Current month working hours
        $currentMonthHours = Attendance::where('employee_id', $employeeId)
            ->whereRaw("strftime('%m', date) = ?", [now()->format('m')])
            ->whereRaw("strftime('%Y', date) = ?", [now()->format('Y')])
            ->sum('working_hours');

        // Monthly attendance chart - fetch all records for the year, group in PHP (cross-database)
        $monthlyRaw = Attendance::where('employee_id', $employeeId)
            ->whereRaw("strftime('%Y', date) = ?", [now()->format('Y')])
            ->whereRaw("strftime('%m', date) <= ?", [now()->format('m')])
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

        // Weekly summary - fetch and group in PHP (cross-database)
        $weekStart = now()->startOfWeek();
        $weekEnd = $weekStart->copy()->addDays(5);
        $weeklyRecords = Attendance::whereBetween('date', [$weekStart, $weekEnd])
            ->where('status', 'Present')
            ->get(['date']);

        $weeklyGrouped = $weeklyRecords->groupBy(fn($r) => $r->date->format('Y-m-d'));

        $totalEmployees = Employee::count();
        $weeklySummary = [];
        for ($i = 0; $i < 6; $i++) {
            $dayDate = $weekStart->copy()->addDays($i);
            $presentCount = ($weeklyGrouped->get($dayDate->format('Y-m-d'), collect()))->count();
            $percentage = $totalEmployees ? round(($presentCount / $totalEmployees) * 100) : 0;
            $weeklySummary[] = [
                'day' => $dayDate->format('l'),
                'present' => $percentage,
            ];
        }

        return view('AttendanceLeave.attendance.index', compact(
            'employee', 'present', 'late', 'undertime', 'absent', 'rate',
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
    $workingHours = 0;

    if ($request->check_in && $request->check_out) {

        $checkIn = strtotime($request->check_in);
        $checkOut = strtotime($request->check_out);

        $workingHours = round(
            ($checkOut - $checkIn) / 3600,
            2
        );
    }

    Attendance::create([
        'employee_id' => $request->employee_id,
        'status' => $request->status,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'working_hours' => $workingHours,
    ]);

    return redirect('/attendance');
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

    $workingHours = 0;

    if ($request->check_in && $request->check_out) {

        $checkIn = strtotime($request->check_in);
        $checkOut = strtotime($request->check_out);

        $workingHours = round(
            ($checkOut - $checkIn) / 3600,
            2
        );
    }

    $attendance->update([
        'employee_id' => $request->employee_id,
        'status' => $request->status,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'working_hours' => $workingHours,
    ]);

    return redirect('/attendance');
}

    // DELETE
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return redirect('/attendance');
    }
    

    // REPORT
    public function report()
    {
        $attendances = Attendance::with('employee')->get();

        return view('AttendanceLeave.attendance.report', compact('attendances'));
    }
}
