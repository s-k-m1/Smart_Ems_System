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
        Employee::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'department'=>$request->department,
            'position'=>$request->position,
            'basic_salary'=>$request->basic_salary,
        ]);
    }
}