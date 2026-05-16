<?php

use Illuminate\Support\Facades\Route;

Route::get('/payroll', function () {
    return view('payroll_reports.payroll.index');
})->name('payroll.index');

