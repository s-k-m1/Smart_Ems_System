<?php

use App\Http\Controllers\AttendanceLeave\AttendanceDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceLeave\LeaveController;
use App\Http\Controllers\NotificationManagement\NotificationController;

/*
|--------------------------------------------------------------------------
| Attendance Routes
|--------------------------------------------------------------------------
*/

Route::get('/attendance', [AttendanceDashboardController::class, 'index']);
Route::get('/attendance/create', [AttendanceDashboardController::class, 'create']);
Route::post('/attendance/store', [AttendanceDashboardController::class, 'store']);

Route::get('/attendance/{id}/edit', [AttendanceDashboardController::class, 'edit']);
Route::post('/attendance/{id}/update', [AttendanceDashboardController::class, 'update']);

Route::get('/attendance/{id}/delete', [AttendanceDashboardController::class, 'destroy']);

Route::get('/attendance/report', [AttendanceDashboardController::class, 'report']);

/*
|--------------------------------------------------------------------------
| Leave Routes
|--------------------------------------------------------------------------
*/

Route::get('/leave', [LeaveController::class, 'index']);
Route::post('/leave/store', [LeaveController::class,'store']);

/*
|--------------------------------------------------------------------------
| Notification Management Routes
|--------------------------------------------------------------------------
*/

// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::get('/notifications/create', [NotificationController::class, 'create'])
    ->name('notifications.create');

Route::post('/notifications/store', [NotificationController::class, 'store'])
    ->name('notifications.store');

Route::get('/notifications/{id}', [NotificationController::class, 'show'])
    ->name('notifications.show');

Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])
    ->name('notifications.edit');

Route::post('/notifications/{id}/update', [NotificationController::class, 'update'])
    ->name('notifications.update');

Route::delete('/notifications/{id}/delete', [NotificationController::class, 'destroy'])
    ->name('notifications.destroy');
    
Route::post('/notifications/{id}/pin', [NotificationController::class, 'pin'])
    ->name('notifications.pin');

Route::post('/notifications/{id}/unpin', [NotificationController::class, 'unpin'])
    ->name('notifications.unpin');