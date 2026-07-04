<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();

        return view('employees.index', [
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateEmployee($request);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', [
            'employee' => $employee,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $this->validateEmployee($request, $employee->id);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    // Shared validation for store() and update(). $ignoreId lets update()
    // skip the unique check against the employee's own current record.
    private function validateEmployee(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id,' . $ignoreId,
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'email' => 'required|email|unique:employees,email,' . $ignoreId,
            'phone' => 'required|string|max:30',
            'joined' => 'required|date',
            'address' => 'required|string|max:255',
            'image' => 'nullable|url',
            'present_days' => 'required|integer|min:0',
            'leave_taken' => 'required|integer|min:0',
            'salary' => 'required|numeric|min:0',
            'projects' => 'required|integer|min:0',
        ]);
    }
}