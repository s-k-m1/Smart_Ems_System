<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PermissionController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/core', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard')->middleware('permission:view_dashboard');
    Route::get('/admin/dashboard/chart-data', [DashboardController::class, 'chartData'])
        ->name('admin.dashboard.chart-data')->middleware('permission:view_dashboard');

    Route::get('/hr/dashboard', [DashboardController::class, 'hr'])
        ->name('hr.dashboard')->middleware('permission:view_dashboard');

    Route::get('/hr/dashboard/chart-data', [DashboardController::class, 'hrChartData'])
        ->name('hr.dashboard.chart-data')->middleware('permission:view_dashboard');

    Route::get('/employee/dashboard', [DashboardController::class, 'employee'])
        ->name('employee.dashboard')->middleware('permission:view_dashboard');

    Route::middleware('permission:manage_payroll')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/permissions', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });
});
