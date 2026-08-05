<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        if (auth()->user()->isEmployee()) {
            $employee = auth()->user()->employee;
            return view('employees.index', [
                'employees' => $employee ? collect([$employee]) : collect(),
                'isEmployee' => true,
            ]);
        }

        $employees = Employee::latest()->paginate(10);

        return view('employees.index', [
            'employees' => $employees,
            'isEmployee' => false,
        ]);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateEmployee($request);

        $employee = Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function edit(Employee $employee)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasAnyRole([User::ROLE_ADMIN, User::ROLE_HR]) && (!$user->employee || $user->employee->id !== $employee->id))) {
            abort(403, 'Unauthorized. You can only edit your own profile.');
        }

        return view('employees.edit', [
            'employee' => $employee,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasAnyRole([User::ROLE_ADMIN, User::ROLE_HR]) && (!$user->employee || $user->employee->id !== $employee->id))) {
            abort(403, 'Unauthorized. You can only edit your own profile.');
        }

        $validated = $this->validateEmployee($request, $employee->id);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

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
