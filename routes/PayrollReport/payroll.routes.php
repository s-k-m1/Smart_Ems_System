<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/payroll', [PayrollController::class, 'index'])
        ->name('payroll.index');

    Route::get('/payroll/create', [PayrollController::class, 'create'])
        ->name('payroll.create');

    Route::post('/payroll', [PayrollController::class, 'store'])
        ->name('payroll.store');

    Route::patch('/payroll/{id}/paid', [PayrollController::class, 'markAsPaid'])
        ->name('payroll.paid');

    Route::delete('/payroll/{id}', [PayrollController::class, 'destroy'])
        ->name('payroll.destroy');

    Route::get('/payroll/{id}/edit', [PayrollController::class, 'edit'])
        ->name('payroll.edit');

    Route::put('/payroll/{id}', [PayrollController::class, 'update'])
        ->name('payroll.update');
});
