<?php

namespace App\Http\Controllers\AttendanceLeave;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

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

        $present = Attendance::where('employee_id', $employee->id)
            ->where('status', 'Present')
            ->count();

        $late = Attendance::where('employee_id', $employee->id)
            ->where('status', 'Late')
            ->count();

        $undertime = Attendance::where('employee_id', $employee->id)
            ->where('status', 'Undertime')
            ->count();

        $absent = Attendance::where('employee_id', $employee->id)
            ->where('status', 'Absent')
            ->count();

        $total = $present + $late + $undertime + $absent;

        $rate = $total
            ? round(($present / $total) * 100)
            : 0;

        // Monthly Attendance Data
        $monthlyAttendance = [];

        for ($month = 1; $month <= now()->month; $month++) {

            $monthPresent = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', now()->year)
                ->where('status', 'Present')
                ->count();

            $monthTotal = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', now()->year)
                ->count();

            $percentage = $monthTotal
                ? round(($monthPresent / $monthTotal) * 100)
                : 0;

            $monthlyAttendance[] = [
                'month' => date('F', mktime(0, 0, 0, $month, 1)),
                'percentage' => $percentage,
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
                'monthlyAttendance'
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
        Attendance::create($request->all());
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
        $attendance->update($request->all());

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