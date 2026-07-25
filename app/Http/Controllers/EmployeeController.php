<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create(){
        return view('EmployeeManagement.employees.create');
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:100',
            'email'=>'required|email|unique:employees,email',
            'department'=>'required|max:100',
            'position'=>'required|max:100',
            'basic_salary'=> 'required|numeric|min:0',
        ]);

        Employee::create([
            'name'=>ucwords(strtolower(trim($request->name))),
            'email'=>strtolower(trim($request->email)),
            'department'=>ucwords(strtolower(trim($request->department))),
            'position'=>ucwords(strtolower(trim($request->position))),
            'basic_salary'=>$request->basic_salary,
        ]);
        return redirect('/employees/create') ->with('success','Employee added successfully.');
    }
}