<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Models\Attendance;

class PayrollController extends Controller
{
    public function create()
    {
        $employees = Employee::all();
        return view('PayrollReport.payroll.create', compact('employees'));
    }
    public function store(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $month = $request->month;
        $year = $request->year;

        $exists = Payroll::where('employee_id', $employee->id)
            ->where('month',$month)
            ->where('year',$year)
            ->exists();

        if($exists){
            return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Payroll for this employee already exists for this month.');
        }

        $absentDays = Attendance::where('employee_id', $employee->id)
            ->whereYear('date',$year)
            ->whereMonth('date',date('n', strtotime($month)))
            ->where('status','Absent')
            ->count();
        $paidLeave= 2;
        $deductibleDays =max(0, $absentDays-$paidLeave);
        $perDaySalary = $employee->basic_salary / 30;
        $leaveDeduction = $perDaySalary * $deductibleDays;
        $netSalary = $employee->basic_salary + $request->bonus - $leaveDeduction;

        Payroll::create([
            'employee_id' => $employee->id,
            'month' => $request->month,
            'year' => $request->year,
            'bonus' => $request->bonus,
            'unpaid_leave_days' => $absentDays,
            'leave_deduction' => $leaveDeduction,
            'net_salary' => $netSalary,
            'status' => 'Pending',
        ]);
        return redirect('/payroll');
    }
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->get();

        foreach($payrolls as $payroll){
            $monthNumber = date('n', strtotime($payroll->month));
           $payroll->setAttribute(
    'present_days',
    Attendance::where('employee_id', $payroll->employee_id)
        ->whereYear('date', $payroll->year)
        ->whereMonth('date', $monthNumber)
        ->where('status', 'Present')
        ->count()
);

$payroll->setAttribute(
    'absent_days',
    Attendance::where('employee_id', $payroll->employee_id)
        ->whereYear('date', $payroll->year)
        ->whereMonth('date', $monthNumber)
        ->where('status', 'Absent')
        ->count()
);
        }
        $totalEmployees = Employee::count();
        $totalPayrolls = Payroll::count();
        $paidPayrolls = Payroll::where('status', 'Paid')->count();
        $pendingPayrolls = Payroll::where('status', 'Pending')->count();
        return view('PayrollReport.payroll.index', compact(
            'payrolls',
            'totalEmployees',
            'totalPayrolls',
            'paidPayrolls',
            'pendingPayrolls'
        ));
    }
    public function markAsPaid($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->status = "Paid";
        $payroll->save();
        return redirect('/payroll')->with('success', 'Payroll marked as Paid.');
    }
    public function destroy($id)
    {
        $payroll = payroll::findOrFail($id);
        $payroll->delete();
        return redirect('/payroll')->with('success', 'Payroll Deleted successfully.');
    }
    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employees = Employee::all();
        return view('PayrollReport.payroll.create', compact('payroll', 'employees'));
    }
    public function update(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);
        $employee = Employee::findOrFail($request->employee_id);
        $month = $request->month;
        $year = $request->year;
        $absentDays = Attendance::where('employee_id',$employee->id)
            ->whereYear('date',$year)
            ->whereMonth('date',date('n',strtotime($month)))
            ->where('status','Absent')
            ->count();
        $paidLeave =2;
        $perDaySalary = $employee->basic_salary / 30;
        $deductibleDays = max(0, $absentDays - $paidLeave);
        $leaveDeduction = $perDaySalary * $deductibleDays;
        $netSalary = $employee->basic_salary + $request->bonus - $leaveDeduction;

        $payroll->update([
            'employee_id' => $employee->id,
            'month' => $request->month,
            'year' => $request->year,
            'bonus' => $request->bonus,
            'unpaid_leave_days' => $absentDays,
            'leave_deduction' => $leaveDeduction,
            'net_salary' => $netSalary,
        ]);
        return redirect('/payroll')->with('success', 'Payroll updated successfully.');
    }
}
