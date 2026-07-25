<?php

namespace App\Http\Controllers\PayrollReport;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->latest()
            ->paginate(15);

        return view('PayrollReport.payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'Active')->orderBy('name')->get();
        return view('PayrollReport.payroll.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month'       => 'required|regex:/^\d{4}-\d{2}$/',
            'basic_salary' => 'required|numeric|min:0',
            'allowances'   => 'required|numeric|min:0',
            'deductions'   => 'required|numeric|min:0',
            'net_pay'      => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status'       => 'required|in:pending,paid,cancelled',
            'notes'        => 'nullable|string|max:1000',
        ]);

        Payroll::create($validated);

        return redirect()->route('payroll.index')
            ->with('success', 'Payroll record created successfully.');
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('employee');
        return view('PayrollReport.payroll.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::where('status', 'Active')->orderBy('name')->get();
        return view('PayrollReport.payroll.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'employee_id'  => 'required|exists:employees,id',
            'month'        => 'required|regex:/^\d{4}-\d{2}$/',
            'basic_salary' => 'required|numeric|min:0',
            'allowances'   => 'required|numeric|min:0',
            'deductions'   => 'required|numeric|min:0',
            'net_pay'      => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status'       => 'required|in:pending,paid,cancelled',
            'notes'        => 'nullable|string|max:1000',
        ]);

        $payroll->update($validated);

        return redirect()->route('payroll.index')
            ->with('success', 'Payroll record updated successfully.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payroll.index')
            ->with('success', 'Payroll record deleted successfully.');
    }
}
