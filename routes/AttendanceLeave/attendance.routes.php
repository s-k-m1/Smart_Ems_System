<?php

use Illuminate\Support\Facades\Route;

Route::get('/attendance', function () {
    return view('AttendanceLeave.attendance.index');
})->name('attendance.index');

