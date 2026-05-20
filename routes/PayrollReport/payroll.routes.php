<?php

use Illuminate\Support\Facades\Route;

Route::get('/payroll', function () {
    return view('Payrollreport.payroll.index');
})->name('payroll.index');

