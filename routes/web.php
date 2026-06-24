<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Add this line into your existing routes/web.php
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
?>