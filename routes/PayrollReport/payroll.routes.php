<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;

Route::get('/payroll',[PayrollController::class, 'index'])
->name('payroll.index');

