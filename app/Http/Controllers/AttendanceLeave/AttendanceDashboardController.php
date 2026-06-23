<?php

namespace App\Http\Controllers\AttendanceLeave;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\CompanySetting;

class AttendanceDashboardController extends Controller
{
    // DASHBOARD
    public function index()
    {
        $employee = Employee::first();

        if (!$employee) {
            return view('AttendanceLeave.attendance.index', [
                'employee' => null
            ]);
        }

        // Company Settings
    $settings = CompanySetting::first();

    $monthlyWorkingHours =
        $settings->monthly_working_hours ?? 205;

    $annualLeaves =
        $settings->annual_leave_days ?? 12;

    $weeklyHoliday =
        $settings->weekly_holiday ?? 'Saturday';

    // Attendance Counts
    $present = Attendance::where(
        'employee_id',
        $employee->id
    )
    ->where('status', 'Present')
    ->count();

    $late = Attendance::where(
        'employee_id',
        $employee->id
    )
    ->where('status', 'Late')
    ->count();

    $undertime = Attendance::where(
        'employee_id',
        $employee->id
    )
    ->where('status', 'Undertime')
    ->count();

    $absent = Attendance::where(
        'employee_id',
        $employee->id
    )
    ->where('status', 'Absent')
    ->count();

    $total =
        $present +
        $late +
        $undertime +
        $absent;

    $rate = $total
        ? round(($present / $total) * 100)
        : 0;

    // Current Month Working Hours
    $currentMonthHours =
        Attendance::where(
            'employee_id',
            $employee->id
        )
        ->whereMonth(
            'date',
            now()->month
        )
        ->whereYear(
            'date',
            now()->year
        )
        ->sum(
            'working_hours'
        );

    // Monthly Attendance Chart
    $monthlyAttendance = [];

    for ($month = 1; $month <= now()->month; $month++) {

        $monthPresent =
            Attendance::where(
                'employee_id',
                $employee->id
            )
            ->whereMonth(
                'date',
                $month
            )
            ->whereYear(
                'date',
                now()->year
            )
            ->where(
                'status',
                'Present'
            )
            ->count();

        $monthTotal =
            Attendance::where(
                'employee_id',
                $employee->id
            )
            ->whereMonth(
                'date',
                $month
            )
            ->whereYear(
                'date',
                now()->year
            )
            ->count();

        $percentage =
            $monthTotal
            ? round(
                ($monthPresent /
                $monthTotal) * 100
            )
            : 0;

        $monthlyAttendance[] = [
            'month' => date(
                'F',
                mktime(
                    0,
                    0,
                    0,
                    $month,
                    1
                )
            ),
            'percentage' => $percentage,
        ];
    }

    // Weekly Summary
    $weeklySummary = [];

    for ($i = 0; $i < 6; $i++) {

        $dayDate =
            now()
            ->startOfWeek()
            ->addDays($i);

        $totalEmployees =
            Employee::count();

        $presentEmployees =
            Attendance::whereDate(
                'date',
                $dayDate
            )
            ->where(
                'status',
                'Present'
            )
            ->count();

        $percentage =
            $totalEmployees
            ? round(
                ($presentEmployees /
                $totalEmployees) * 100
            )
            : 0;

        $weeklySummary[] = [

            'day' =>
                $dayDate->format('l'),

            'present' =>
                $percentage,
        ];
    }

    return view(
        'AttendanceLeave.attendance.index',
        compact(
            'employee',
            'present',
            'late',
            'undertime',
            'absent',
            'rate',
            'monthlyAttendance',
            'monthlyWorkingHours',
            'annualLeaves',
            'weeklyHoliday',
            'currentMonthHours',
            'weeklySummary'
        )
    );
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