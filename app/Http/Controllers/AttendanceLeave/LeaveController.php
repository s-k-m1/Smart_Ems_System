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
        $history = Leave::orderBy('created_at', 'desc')->get();

        return view('AttendanceLeave.attendance.LeaveManagement.leave', compact('history'));
    }

    // STORE LEAVE
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'reason' => 'required'
        ]);

        $days = Carbon::parse($request->from_date)
                ->diffInDays(Carbon::parse($request->to_date)) + 1;

        Leave::create([
            'type' => $request->type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'days' => $days,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);

        return redirect('/leave')->with('success', 'Leave Applied Successfully');
    }
}