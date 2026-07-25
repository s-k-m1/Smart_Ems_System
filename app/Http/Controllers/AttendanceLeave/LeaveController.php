<?php

namespace App\Http\Controllers\AttendanceLeave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Carbon\Carbon;

class LeaveController extends Controller
{
    // SHOW PAGE
    public function index()
    {
        $user = auth()->user();

        // Employee: only see own leave records
        if ($user->isEmployee()) {
            $employee = $user->employee;
            if ($employee) {
                $history = Leave::where('employee_id', $employee->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $history = collect();
            }

            return view('AttendanceLeave.attendance.LeaveManagement.leave', compact('history'));
        }

        // Admin / HR: see all leave records
        $history = Leave::orderBy('created_at', 'desc')->get();

        return view('AttendanceLeave.attendance.LeaveManagement.leave', compact('history'));
    }

    // STORE LEAVE
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
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
}
