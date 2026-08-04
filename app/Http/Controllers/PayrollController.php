<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function create(){
        $employees=Employee::all();
        return view('PayrollReport.payroll.create',compact('employees'));
    }
    public function store(Request $request){
        $employee = Employee::find($request->employee_id);
        $perDaySalary= $employee->salary/30;
        $leaveDeduction = $perDaySalary *$request->unpaid_leave_days;
        $netSalary= $employee->salary + $request-> bonus -$leaveDeduction;

        Payroll::create([
            'employee_id'=>$employee->id,
            'month'=>$request->month,
            'year'=>$request->year,
            'bonus'=>$request->bonus,
            'unpaid_leave_days'=>$request->unpaid_leave_days,
            'leave_deduction'=>$leaveDeduction,
            'net_salary'=>$netSalary,
            'status'=>'Pending',
        ]);
        return redirect('/payroll');
    }
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->get();
        $totalEmployees = Employee::count();
        $totalPayrolls =Payroll::count();
        $paidPayrolls= Payroll::where('status','Paid')->count();
        $pendingPayrolls= Payroll::where('status','Pending')->count();
        return view('PayrollReport.payroll.index',compact(
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
        $payroll->status ="Paid";
        $payroll->save();
        return redirect('/payroll')->with('success', 'Payroll marked as Paid.');
    }
    public function destroy($id)
    {
        $payroll=payroll::findOrFail($id);
        $payroll->delete();
        return redirect('/payroll')->with('success','Payroll Deleted successfully.');
    }
    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employees = Employee::all();
        return view('PayrollReport.payroll.create',compact('payroll','employees'));
    }
    public function update(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);
        $employee = Employee::findOrFail($request->employee_id);
        $perDaySalary = $employee->salary /30;
        $leaveDeduction = $perDaySalary*$request->unpaid_leave_days;
        $netSalary = $employee->salary+ $request->bonus- $leaveDeduction;

        $payroll->update([
            'employee_id'=>$employee->id,
            'month' => $request->month,
        'year' => $request->year,
        'bonus' => $request->bonus,
        'unpaid_leave_days' => $request->unpaid_leave_days,
        'leave_deduction' => $leaveDeduction,
        'net_salary' => $netSalary,
        ]);
        return redirect('/payroll')->with('success','Payroll updated successfully.');
    }
}
