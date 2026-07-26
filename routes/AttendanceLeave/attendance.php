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

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/attendance', [AttendanceDashboardController::class, 'index']);
    Route::get('/attendance/create', [AttendanceDashboardController::class, 'create'])->middleware('role:admin,hr');
    Route::post('/attendance/store', [AttendanceDashboardController::class, 'store'])->middleware('role:admin,hr');

    Route::get('/attendance/{id}/edit', [AttendanceDashboardController::class, 'edit'])->middleware('role:admin,hr');
    Route::post('/attendance/{id}/update', [AttendanceDashboardController::class, 'update'])->middleware('role:admin,hr');

    Route::delete('/attendance/{id}/delete', [AttendanceDashboardController::class, 'destroy'])->middleware('role:admin,hr');

    Route::get('/attendance/report', [AttendanceDashboardController::class, 'report'])->middleware('role:admin,hr');

    /*
    |--------------------------------------------------------------------------
    | Leave Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/leave', [LeaveController::class, 'index']);
    Route::post('/leave/store', [LeaveController::class,'store'])->middleware('role:admin,hr,employee');
    Route::post('/leave/{id}/approve', [LeaveController::class, 'approve'])->middleware('role:admin,hr');
    Route::post('/leave/{id}/reject', [LeaveController::class, 'reject'])->middleware('role:admin,hr');

    /*
    |--------------------------------------------------------------------------
    | Notification Management Routes
    |--------------------------------------------------------------------------
    */

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/create', [NotificationController::class, 'create'])
        ->name('notifications.create')
        ->middleware('role:admin,hr');

    Route::post('/notifications/store', [NotificationController::class, 'store'])
        ->name('notifications.store')
        ->middleware('role:admin,hr');

    Route::get('/notifications/{id}', [NotificationController::class, 'show'])
        ->name('notifications.show');

    Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])
        ->name('notifications.edit')
        ->middleware('role:admin,hr');

    Route::post('/notifications/{id}/update', [NotificationController::class, 'update'])
        ->name('notifications.update')
        ->middleware('role:admin,hr');

    Route::delete('/notifications/{id}/delete', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy')
        ->middleware('role:admin,hr');

    Route::post('/notifications/{id}/pin', [NotificationController::class, 'pin'])
        ->name('notifications.pin')
        ->middleware('role:admin,hr');

    Route::post('/notifications/{id}/unpin', [NotificationController::class, 'unpin'])
        ->name('notifications.unpin')
        ->middleware('role:admin,hr');

});
