<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/core', function () {
        return view('CoreSystem.dashboard.index');
    })->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('CoreSystem.dashboard.admin');
    })->name('admin.dashboard')->middleware('role:admin');

    Route::get('/hr/dashboard', function () {
        return view('CoreSystem.dashboard.hr');
    })->name('hr.dashboard')->middleware('role:hr');

    Route::get('/employee/dashboard', function () {
        return view('CoreSystem.dashboard.employee');
    })->name('employee.dashboard')->middleware('role:employee');
});
