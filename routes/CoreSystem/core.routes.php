<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/core', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard')->middleware('role:admin');

    Route::get('/hr/dashboard', [DashboardController::class, 'hr'])
        ->name('hr.dashboard')->middleware('role:hr');

    Route::get('/employee/dashboard', [DashboardController::class, 'employee'])
        ->name('employee.dashboard')->middleware('role:employee');
});
