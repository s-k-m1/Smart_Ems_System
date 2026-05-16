<?php

use Illuminate\Support\Facades\Route;

Route::get('/core', function () {
    return view('core_system.dashboard.index');
})->name('dashboard');