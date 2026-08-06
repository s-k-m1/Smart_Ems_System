<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $attendanceEmployees = Attendance::with('employee')
            ->get()
            ->map(fn($a) => $a->employee->name)
            ->unique()
            ->sort()
            ->values();

        $attendanceSummary = ['total' => 0, 'present' => 0, 'absent' => 0, 'leave' => 0];

        $attendanceQuery = Attendance::with('employee');

        if ($request->filled('att_from')) {
            $attendanceQuery->where('date', '>=', $request->input('att_from'));
        }
        if ($request->filled('att_to')) {
            $attendanceQuery->where('date', '<=', $request->input('att_to'));
        }
        if ($request->filled('att_employee')) {
            $attendanceQuery->whereHas('employee', function ($q) use ($request) {
                $q->where('name', $request->input('att_employee'));
            });
        }
        if ($request->filled('att_status')) {
            $attendanceQuery->where('status', $request->input('att_status'));
        }
        if ($request->filled('att_search')) {
            $search = $request->input('att_search');
            $attendanceQuery->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $attendancePaginated = $attendanceQuery->paginate(10);
        $attendanceData = $attendancePaginated->getCollection()->map(fn($a) => [
            'id'     => $a->id,
            'name'   => $a->employee->name,
            'date'   => $a->date,
            'status' => $a->status === 'Late' || $a->status === 'Undertime' ? 'Present' : $a->status,
        ]);

        $attendanceSummary = [
            'total'   => $attendancePaginated->total(),
            'present' => $attendanceData->where('status', 'Present')->count(),
            'absent'  => $attendanceData->where('status', 'Absent')->count(),
            'leave'   => $attendanceData->where('status', 'Leave')->count(),
        ];

        $departments = Employee::query()
            ->get()
            ->pluck('department')
            ->unique()
            ->sort()
            ->values();

        $distQuery = Employee::query();

        if ($request->filled('dist_dept')) {
            $distQuery->where('department', $request->input('dist_dept'));
        }
        if ($request->filled('dist_search')) {
            $search = $request->input('dist_search');
            $distQuery->where('name', 'like', "%{$search}%");
        }

        $distributionPaginated = $distQuery->paginate(10);
        $distributionData = $distributionPaginated->getCollection()->map(fn($e) => [
            'id'          => $e->id,
            'name'        => $e->name,
            'department'  => $e->department,
            'designation' => $e->position,
        ]);

        $leaveQuery = Leave::with('employee');

        if ($request->filled('leave_from')) {
            $leaveQuery->where('from_date', '>=', $request->input('leave_from'));
        }
        if ($request->filled('leave_to')) {
            $leaveQuery->where('to_date', '<=', $request->input('leave_to'));
        }
        if ($request->filled('leave_employee')) {
            $leaveQuery->whereHas('employee', function ($q) use ($request) {
                $q->where('name', $request->input('leave_employee'));
            });
        }
        if ($request->filled('leave_type')) {
            $leaveQuery->where('type', $request->input('leave_type'));
        }
        if ($request->filled('leave_status')) {
            $leaveQuery->where('status', $request->input('leave_status'));
        }
        if ($request->filled('leave_search')) {
            $search = $request->input('leave_search');
            $leaveQuery->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $leavePaginated = $leaveQuery->paginate(10);
        $leaveData = $leavePaginated->getCollection()->map(fn($l) => [
            'id'         => $l->id,
            'name'       => $l->employee->name,
            'type'       => $l->type,
            'from_date'  => $l->from_date,
            'to_date'    => $l->to_date,
            'days'       => $l->days,
            'reason'     => $l->reason,
            'status'     => $l->status,
            'approver'   => $l->approver,
        ]);

        $leaveTypes = Leave::query()
            ->get()
            ->pluck('type')
            ->unique()
            ->sort()
            ->values();

        return view('report', compact(
            'attendanceData', 'attendanceEmployees', 'attendanceSummary',
            'attendancePaginated', 'distributionData', 'departments',
            'distributionPaginated', 'leaveData', 'leaveTypes', 'leavePaginated'
        ));
    }
}