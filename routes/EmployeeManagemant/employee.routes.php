<?php

use Illuminate\Support\Facades\Route;

Route::get('/employees', function () {
    return view('EmployeeManagement.employees.index');
})->name('employees.index');
