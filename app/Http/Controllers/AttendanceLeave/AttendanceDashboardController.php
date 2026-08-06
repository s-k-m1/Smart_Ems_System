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
    // Allowed date range: Admin can use any previous date, HR up to 7 days back, employees only today
    private function allowedDateRange(): array
    {
        if (auth()->user()->isEmployee()) {
            return [
                'min' => now()->format('Y-m-d'),
                'max' => now()->format('Y-m-d'),
            ];
        }

        if (auth()->user()->isAdmin()) {
            return [
                'min' => now()->subYears(5)->format('Y-m-d'),
                'max' => now()->format('Y-m-d'),
            ];
        }

        return [
            'min' => now()->subDays(7)->format('Y-m-d'),
            'max' => now()->format('Y-m-d'),
        ];
    }

    private function dateWithinAllowedRange($date): bool
    {
        $range = $this->allowedDateRange();
        $value = \Carbon\Carbon::parse($date)->format('Y-m-d');

        return $value >= $range['min'] && $value <= $range['max'];
    }

    private function denyEmployeeWrite(): void
    {
        abort_if(auth()->user()->isEmployee(), 403, 'Employees can only record today\'s attendance and cannot edit or delete records.');
    }

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
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfDay()])
            ->sum('working_hours');

        // Weekly summary (scoped to the selected employee)
        $weekStart = now()->startOfWeek();
        $weekEnd = $weekStart->copy()->addDays(5)->endOfDay();
        $weeklyRecords = Attendance::where('employee_id', $selectedEmployeeId)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->where('status', 'Present')
            ->get(['date']);

        $weeklyGrouped = $weeklyRecords->groupBy(fn($r) => \Carbon\Carbon::parse($r->date)->format('Y-m-d'));
        $weeklySummary = [];
        for ($i = 0; $i < 6; $i++) {
            $dayDate = $weekStart->copy()->addDays($i);
            $presentCount = ($weeklyGrouped->get($dayDate->format('Y-m-d'), collect()))->count();
            $weeklySummary[] = [
                'day' => $dayDate->format('l'),
                'present' => $presentCount ? 100 : 0,
            ];
        }

        $todayAttendance = Attendance::where('employee_id', $selectedEmployeeId)
            ->whereDate('date', now('Asia/Kathmandu')->toDateString())
            ->first();

        return view('AttendanceLeave.attendance.index', compact(
            'employee', 'employeesForSelect',
            'present', 'late', 'undertime', 'absent', 'rate',
            'monthlyWorkingHours', 'annualLeaves',
            'weeklyHoliday', 'currentMonthHours', 'weeklySummary',
            'todayAttendance'
        ));
    }

    // CHART DATA (JSON)
    public function chartData(Request $request)
    {
        $user = auth()->user();
        $allEmployees = Employee::all();

        if ($user->isEmployee()) {
            $employee = $user->employee;
            $selectedEmployeeId = $employee?->id;
        } else {
            $selectedEmployeeId = $request->integer('employee');
            if (!$selectedEmployeeId || !$allEmployees->contains('id', $selectedEmployeeId)) {
                $selectedEmployeeId = $allEmployees->first()?->id;
            }
            $employee = $allEmployees->firstWhere('id', $selectedEmployeeId);
        }

        $labels = [];
        $present = [];
        $late = [];
        $undertime = [];
        $absent = [];
        $rates = [];

        if ($selectedEmployeeId) {
            $monthlyRaw = Attendance::where('employee_id', $selectedEmployeeId)
                ->whereBetween('date', [now()->startOfYear(), now()->endOfDay()])
                ->get(['date', 'status']);

            $monthlyGrouped = $monthlyRaw->groupBy(fn($r) => (int)\Carbon\Carbon::parse($r->date)->format('m'));

            for ($month = 1; $month <= now()->month; $month++) {
                $monthData = $monthlyGrouped->get($month, collect());
                $p = $monthData->where('status', 'Present')->count();
                $l = $monthData->where('status', 'Late')->count();
                $u = $monthData->where('status', 'Undertime')->count();
                $a = $monthData->where('status', 'Absent')->count();
                $total = $p + $l + $u + $a;

                $labels[] = date('M', mktime(0, 0, 0, $month, 1));
                $present[] = $p;
                $late[] = $l;
                $undertime[] = $u;
                $absent[] = $a;
                $rates[] = $total ? round(($p / $total) * 100) : 0;
            }
        }

        $yearCounts = $selectedEmployeeId
            ? Attendance::where('employee_id', $selectedEmployeeId)
                ->whereBetween('date', [now()->startOfYear(), now()->endOfDay()])
                ->selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
            : collect();

        $yearTotal = array_sum($yearCounts->all());
        $yearPresent = ($yearCounts['Present'] ?? 0) + ($yearCounts['Late'] ?? 0) + ($yearCounts['Undertime'] ?? 0);

        return response()->json([
            'labels' => $labels,
            'present' => $present,
            'late' => $late,
            'undertime' => $undertime,
            'absent' => $absent,
            'rates' => $rates,
            'yearRate' => $yearTotal ? round(($yearPresent / $yearTotal) * 100) : 0,
            'employee' => $employee?->name ?? null,
            'year' => now()->year,
        ]);
    }
// CREATE PAGE
    public function create()
    {
        $user = auth()->user();
        $range = $this->allowedDateRange();
        $minDate = $range['min'];
        $maxDate = $range['max'];
        $employee = null;

        if ($user->isEmployee()) {
            $employee = $user->employee;
            abort_unless($employee, 403, 'No employee profile linked to your account.');
            $employees = collect([$employee]);
        } else {
            $employees = Employee::all();
        }

        return view('AttendanceLeave.attendance.create', compact('employees', 'minDate', 'maxDate', 'employee'));
    }

    private function detectStatus($checkIn, $checkOut, $workingHours)
    {
        if (!$checkIn) {
            return 'Absent';
        }
        if (!$checkOut) {
            return 'Undertime';
        }
        if ($workingHours < 7) {
            return 'Undertime';
        }
        $cutoff = strtotime('09:00');
        if (strtotime($checkIn) > $cutoff) {
            return 'Late';
        }
        return 'Present';
    }

    // STORE
    public function store(Request $request)
{
    $user = auth()->user();
    $range = $this->allowedDateRange();

    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date|after_or_equal:' . $range['min'] . '|before_or_equal:' . $range['max'],
        'check_in' => 'nullable',
        'check_out' => 'nullable',
    ]);

    // Employees can only record attendance for themselves
    $employeeId = $request->employee_id;
    if ($user->isEmployee()) {
        $employee = $user->employee;
        abort_unless($employee, 403, 'No employee profile linked to your account.');
        $employeeId = $employee->id;
    }

    // prevent duplicate attendance for same employee on same date
    $exists = Attendance::where('employee_id', $employeeId)
        ->whereDate('date', $request->date)
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

    $status = $this->detectStatus($request->check_in, $request->check_out, $workingHours);

    Attendance::create([
        'employee_id' => $employeeId,
        'status' => $status,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'working_hours' => $workingHours,
    ]);

    return redirect('/attendance?employee=' . $employeeId)->with('success', "Attendance recorded as {$status}.");
}

    // EDIT PAGE
    public function edit($id)
    {
        $this->denyEmployeeWrite();

        $attendance = Attendance::findOrFail($id);

        abort_unless(
            $this->dateWithinAllowedRange($attendance->date),
            403,
            'Attendance records can only be edited within the last 7 days.'
        );

        $employees = Employee::all();

        return view('AttendanceLeave.attendance.edit', compact('attendance', 'employees'));
    }

    // UPDATE
    public function update(Request $request, $id)
{
    $this->denyEmployeeWrite();

    $attendance = Attendance::findOrFail($id);

    abort_unless(
        $this->dateWithinAllowedRange($attendance->date),
        403,
        'Attendance records can only be edited within the last 7 days.'
    );

    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date|date_equals:' . \Carbon\Carbon::parse($attendance->date)->format('Y-m-d'),
        'check_in' => 'nullable',
        'check_out' => 'nullable',
    ]);

    $workingHours = 0;
    if ($request->check_in && $request->check_out) {
        $checkIn = strtotime($request->check_in);
        $checkOut = strtotime($request->check_out);
        $workingHours = round(($checkOut - $checkIn) / 3600, 2);
    }

    $status = $this->detectStatus($request->check_in, $request->check_out, $workingHours);

    $attendance->update([
        'employee_id' => $request->employee_id,
        'status' => $status,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'working_hours' => $workingHours,
    ]);

    return redirect('/attendance?employee=' . $request->employee_id)->with('success', "Attendance updated as {$status}.");
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
        $attendances = Attendance::with('employee')->orderBy('date', 'desc')->paginate(10);

        return view('AttendanceLeave.attendance.report', compact('attendances'));
    }

    // QUICK CHECK IN
    public function quickCheckIn()
    {
        $user = auth()->user();
        abort_unless($user->isEmployee(), 403);

        $employee = $user->employee;
        abort_unless($employee, 403, 'No employee profile linked.');

        $today = now('Asia/Kathmandu')->toDateString();
        $exists = Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->exists();

        if ($exists) {
            return back()->withErrors(['check_in' => 'You have already checked in today.'])->withInput();
        }

        $now = now('Asia/Kathmandu');

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $now, // full timestamp so the real click time is stored
            'check_in' => $now->format('H:i:s'),
            'check_out' => null,
            'status' => 'Present',
            'working_hours' => 0,
        ]);

        return redirect('/attendance?employee=' . $employee->id)->with('success', 'Checked in at ' . $now->format('g:i A'));
    }

    // QUICK CHECK OUT
    public function quickCheckOut()
    {
        $user = auth()->user();
        abort_unless($user->isEmployee(), 403);

        $employee = $user->employee;
        abort_unless($employee, 403, 'No employee profile linked.');

        $today = now('Asia/Kathmandu')->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->whereNull('check_out')
            ->first();

        if (!$attendance) {
            return back()->withErrors(['check_out' => 'No active check-in found for today.'])->withInput();
        }

        $now = now('Asia/Kathmandu')->format('H:i:s');
        $checkIn = strtotime($attendance->check_in);
        $checkOut = strtotime($now);
        $workingHours = round(($checkOut - $checkIn) / 3600, 2);
        $status = $this->detectStatus($attendance->check_in, $now, $workingHours);

        $attendance->update([
            'check_out' => $now,
            'status' => $status,
            'working_hours' => $workingHours,
        ]);

        return redirect('/attendance?employee=' . $employee->id)->with('success', 'Checked out at ' . $now . ' — ' . $workingHours . 'h worked');
    }

    // REQUEST EDIT
    public function requestEdit(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->isEmployee(), 403);

        $employee = $user->employee;
        abort_unless($employee, 403, 'No employee profile linked.');

        $attendance = Attendance::findOrFail($id);
        abort_unless($attendance->employee_id === $employee->id, 403);

        // Prevent duplicate requests: one pending edit-request notification per attendance record
        $dateKey = \Carbon\Carbon::parse($attendance->date)->format('Y-m-d');
        $existing = \DB::table('notifications')
            ->where('title', 'Attendance Edit Request')
            ->where('published_by', $user->name)
            ->where('description', 'like', '%for ' . $dateKey . '%')
            ->where('status', true)
            ->exists();

        if ($existing) {
            return back()->with('error', 'An edit request for this attendance has already been sent. HR/Admin has been notified.');
        }

        \DB::table('notifications')->insert([
            'title' => 'Attendance Edit Request',
            'description' => $user->name . ' needs to edit attendance for ' . $attendance->date . '. Check-in: ' . ($attendance->check_in ?? 'N/A') . ', Check-out: ' . ($attendance->check_out ?? 'N/A') . '.',
            'category' => 'HR',
            'priority' => 'Medium',
            'published_by' => $user->name,
            'publish_date' => now('Asia/Kathmandu'),
            'is_pinned' => false,
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $notificationId = \DB::getPdo()->lastInsertId();

        $hrUsers = \App\Models\User::whereIn('role', ['admin', 'hr'])->get();

        foreach ($hrUsers as $hrUser) {
            \DB::table('notification_user')->insert([
                'notification_id' => $notificationId,
                'user_id' => $hrUser->id,
                'is_read' => false,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Edit request sent to HR/Admin.');
    }

    // REPORT ISSUE (employee describes a mistaken check-in/out)
    public function reportIssue(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->isEmployee(), 403);

        $employee = $user->employee;
        abort_unless($employee, 403, 'No employee profile linked.');

        $request->validate([
            'issue' => 'required|string|max:500',
        ]);

        $today = now('Asia/Kathmandu')->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        $dateInfo = $attendance
            ? $attendance->date . ' (In: ' . ($attendance->check_in ?? 'N/A') . ', Out: ' . ($attendance->check_out ?? 'N/A') . ')'
            : 'No record for today.';

        \DB::table('notifications')->insert([
            'title' => 'Attendance Issue Report',
            'description' => $user->name . ' reported an issue for ' . $dateInfo . '. Issue: ' . $request->input('issue'),
            'category' => 'HR',
            'priority' => 'High',
            'published_by' => $user->name,
            'publish_date' => now('Asia/Kathmandu'),
            'is_pinned' => false,
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $notificationId = \DB::getPdo()->lastInsertId();

        $hrUsers = \App\Models\User::whereIn('role', ['admin', 'hr'])->get();

        foreach ($hrUsers as $hrUser) {
            \DB::table('notification_user')->insert([
                'notification_id' => $notificationId,
                'user_id' => $hrUser->id,
                'is_read' => false,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Your issue has been reported to HR/Admin.');
    }
}
