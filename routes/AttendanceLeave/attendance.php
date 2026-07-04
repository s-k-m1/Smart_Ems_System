<?php

use App\Http\Controllers\AttendanceLeave\AttendanceDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceLeave\LeaveController;

Route::get('/attendance', [AttendanceDashboardController::class, 'index']);
Route::get('/attendance/create', [AttendanceDashboardController::class, 'create']);
Route::post('/attendance/store', [AttendanceDashboardController::class, 'store']);

Route::get('/attendance/{id}/edit', [AttendanceDashboardController::class, 'edit']);
Route::post('/attendance/{id}/update', [AttendanceDashboardController::class, 'update']);

Route::get('/attendance/{id}/delete', [AttendanceDashboardController::class, 'destroy']);

Route::get('/attendance/report', [AttendanceDashboardController::class, 'report']);

Route::get('/leave', [LeaveController::class, 'index']);
Route::post('/leave/store', [LeaveController::class,'store']);