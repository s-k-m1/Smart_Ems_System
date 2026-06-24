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
        $perDaySalary= $employee->basic_salary/30;
        $leaveDeduction = $perDaySalary *$request->unpaid_leave_days;
        $netSalary= $employee->basic_salary + $request-> bonus -$leaveDeduction;

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
        return "Payroll Generated Successfully";
    }
}
