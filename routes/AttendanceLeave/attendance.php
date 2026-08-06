<?php

use App\Http\Controllers\AttendanceLeave\AttendanceDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceLeave\LeaveController;
use App\Http\Controllers\NotificationManagement\NotificationController;

/*
|--------------------------------------------------------------------------
|==============================Attendance Routes===============================
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth', 'permission:view_attendance'])->group(function () {

    Route::get('/attendance', [AttendanceDashboardController::class, 'index']);
    Route::get('/attendance/chart-data', [AttendanceDashboardController::class, 'chartData']);
    Route::get('/attendance/create', [AttendanceDashboardController::class, 'create'])->middleware('permission:manage_attendance');
    Route::post('/attendance/store', [AttendanceDashboardController::class, 'store'])->middleware('permission:manage_attendance');

    Route::get('/attendance/{id}/edit', [AttendanceDashboardController::class, 'edit'])->middleware('permission:manage_attendance');
    Route::post('/attendance/{id}/update', [AttendanceDashboardController::class, 'update'])->middleware('permission:manage_attendance');

    Route::delete('/attendance/{id}/delete', [AttendanceDashboardController::class, 'destroy'])->middleware('permission:manage_attendance');

    Route::get('/attendance/report', [AttendanceDashboardController::class, 'report'])->middleware('permission:view_attendance');

    /*
    |--------------------------------------------------------------------------
    | Leave Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/leave', [LeaveController::class, 'index'])->middleware('permission:view_leave');
    Route::post('/leave/store', [LeaveController::class,'store'])->middleware('permission:manage_leave');
    Route::post('/leave/{id}/approve', [LeaveController::class, 'approve'])->middleware('permission:manage_leave');
    Route::post('/leave/{id}/reject', [LeaveController::class, 'reject'])->middleware('permission:manage_leave');

    /*
    |--------------------------------------------------------------------------
    | ==========================Notification Management Routes==========================
    |--------------------------------------------------------------------------
    */

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index')->middleware('permission:view_notifications');

    Route::get('/notifications/create', [NotificationController::class, 'create'])
        ->name('notifications.create')
        ->middleware('permission:manage_notifications');

    Route::post('/notifications/store', [NotificationController::class, 'store'])
        ->name('notifications.store')
        ->middleware('permission:manage_notifications');

    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-read')
        ->middleware('permission:view_notifications');

    Route::get('/notifications/unread-counts', [NotificationController::class, 'unreadCounts'])
        ->name('notifications.unread-counts')
        ->middleware('permission:view_notifications');

    Route::get('/notifications/{id}', [NotificationController::class, 'show'])
        ->name('notifications.show')->middleware('permission:view_notifications');

    Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])
        ->name('notifications.edit')
        ->middleware('permission:manage_notifications');

    Route::post('/notifications/{id}/update', [NotificationController::class, 'update'])
        ->name('notifications.update')
        ->middleware('permission:manage_notifications');

    Route::delete('/notifications/{id}/delete', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy')
        ->middleware('permission:manage_notifications');

    Route::post('/notifications/{id}/pin', [NotificationController::class, 'pin'])
        ->name('notifications.pin')
        ->middleware('permission:manage_notifications');

    Route::post('/notifications/{id}/unpin', [NotificationController::class, 'unpin'])
        ->name('notifications.unpin')
        ->middleware('permission:manage_notifications');

});
