<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\ReportController;
use App\Http\Controllers\Employeecontroller;
use Illuminate\Support\Facades\Route;

// report page
Route::get('/report', [ReportController::class, 'index'])->name('report.index');



// employee detail page

Route::get('/empdetail', [EmployeeController::class, 'index'])->name('empdetail.index');
?>