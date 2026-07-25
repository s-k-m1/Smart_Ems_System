<?php

use App\Http\Controllers\PayrollReport\PayrollController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'role:admin'])->group(function () {
    Route::resource('payroll', PayrollController::class)
        ->names('payroll');
});
