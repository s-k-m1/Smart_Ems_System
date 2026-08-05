<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $attendanceData = collect();
        $attendanceEmployees = Attendance::with('employee')
            ->get()
            ->map(fn($a) => $a->employee->name)
            ->unique()
            ->sort()
            ->values();

        $attendanceSummary = ['total' => 0, 'present' => 0, 'absent' => 0, 'leave' => 0];
        $attendancePaginated = null;

        $distributionData = collect();
        $departments = Employee::query()
            ->get()
            ->pluck('department')
            ->unique()
            ->sort()
            ->values();

        $distributionPaginated = null;

        if ($request->hasAny(['att_from', 'att_to', 'att_employee', 'att_status', 'att_search', 'dist_dept', 'dist_search'])) {
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
        }

        return view('report', compact(
            'attendanceData', 'attendanceEmployees', 'attendanceSummary',
            'attendancePaginated', 'distributionData', 'departments',
            'distributionPaginated'
        ));
    }
}