<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/employees/create',[EmployeeController::class,'create']);
Route::post('/employees',[EmployeeController::class,'store']);
Route::get('/payroll/create',[PayrollController::class,'create']);
Route::post('/payroll',[PayrollController::class,'store']);