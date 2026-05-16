<?php

use Illuminate\Support\Facades\Route;

Route::get('/employees', function () {
    return view('employee_management.employees.index');
})->name('employees.index');
