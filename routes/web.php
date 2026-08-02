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
Route::get('/payroll',[PayrollController::class,'index']);
Route::patch('/payroll/{id}/paid',[PayrollController::class,'markAsPaid'])->name('payroll.paid');
Route::delete('/payroll/{id}',[PayrollController::class,'destroy'])->name('payroll.destroy');
Route::get('/payroll/{id}/edit',[PayrollController::class,'edit'])->name('payroll.edit');
Route::put('/payroll/{id}',[PayrollController::class,'update'])->name('payroll.update');