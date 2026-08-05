<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;

Route::middleware(['web', 'auth', 'permission:view_payroll'])->group(function () {

    Route::get('/payroll', [PayrollController::class, 'index'])
        ->name('payroll.index');

    Route::get('/payroll/create', [PayrollController::class, 'create'])
        ->name('payroll.create');

    Route::post('/payroll', [PayrollController::class, 'store'])
        ->name('payroll.store')
        ->middleware('permission:manage_payroll');

    Route::patch('/payroll/{id}/paid', [PayrollController::class, 'markAsPaid'])
        ->name('payroll.paid')
        ->middleware('permission:manage_payroll');

    Route::delete('/payroll/{id}', [PayrollController::class, 'destroy'])
        ->name('payroll.destroy')
        ->middleware('permission:manage_payroll');

    Route::get('/payroll/{id}/edit', [PayrollController::class, 'edit'])
        ->name('payroll.edit');

    Route::put('/payroll/{id}', [PayrollController::class, 'update'])
        ->name('payroll.update')
        ->middleware('permission:manage_payroll');
});
