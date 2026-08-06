<?php

namespace App\Http\Controllers\AttendanceLeave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Carbon\Carbon;

class LeaveController extends Controller
{
    // SHOW PAGE
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->query('search');

        // Employee: only see own leave records
        if ($user->isEmployee()) {
            $employee = $user->employee;
            if ($employee) {
                $builder = Leave::where('employee_id', $employee->id);

                if ($search) {
                    $builder->where(function ($q) use ($search) {
                        $q->where('type', 'like', "%{$search}%")
                            ->orWhere('from_date', 'like', "%{$search}%")
                            ->orWhere('to_date', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('reason', 'like', "%{$search}%");
                    });
                }

                $history = $builder->orderBy('created_at', 'desc')->paginate(10);

                $annualLeaves = Leave::where('employee_id', $employee->id)->where('type', 'Annual')->count();
                $sickLeaves = Leave::where('employee_id', $employee->id)->where('type', 'Sick')->count();
            } else {
                $history = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
                $annualLeaves = 0;
                $sickLeaves = 0;
            }

            return view('AttendanceLeave.attendance.LeaveManagement.leave', compact('history', 'annualLeaves', 'sickLeaves', 'search'));
        }

        // Admin / HR: see all leave records
        $builder = Leave::with('employee');

        if ($search) {
            $builder->where(function ($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                    ->orWhere('from_date', 'like', "%{$search}%")
                    ->orWhere('to_date', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($eq) use ($search) {
                        $eq->where('name', 'like', "%{$search}%")
                            ->orWhere('employee_id', 'like', "%{$search}%");
                    });
            });
        }

        $history = $builder->orderBy('created_at', 'desc')->paginate(10);
        $annualLeaves = Leave::where('type', 'Annual')->count();
        $sickLeaves = Leave::where('type', 'Sick')->count();

        return view('AttendanceLeave.attendance.LeaveManagement.leave', compact('history', 'annualLeaves', 'sickLeaves', 'search'));
    }

    // STORE LEAVE
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'type' => 'required',
            'from_date' => 'required|date|after_or_equal:' . today()->toDateString(),
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required'
        ]);

        $days = Carbon::parse($request->from_date)
                ->diffInDays(Carbon::parse($request->to_date)) + 1;

        $data = [
            'type' => $request->type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'days' => $days,
            'reason' => $request->reason,
            'status' => 'Pending',
        ];

        // If employee, associate leave with their employee record
        if ($user->isEmployee() && $user->employee) {
            $data['employee_id'] = $user->employee->id;
        }

        Leave::create($data);

        return redirect('/leave')->with('success', 'Leave Applied Successfully');
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 'Approved';
        $leave->approver = auth()->user()->name;
        $leave->save();
        return redirect('/leave')->with('success', 'Leave approved successfully.');
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 'Rejected';
        $leave->approver = auth()->user()->name;
        $leave->save();
        return redirect('/leave')->with('success', 'Leave rejected.');
    }
}
