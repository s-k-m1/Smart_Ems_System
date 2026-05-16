<?php

use Illuminate\Support\Facades\Route;

Route::get('/attendance', function () {
    return view('attendance_leave.attendance.index');
})->name('attendance.index');

