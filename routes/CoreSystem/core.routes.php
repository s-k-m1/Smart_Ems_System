<?php

use Illuminate\Support\Facades\Route;

Route::get('/core', function () {
    return view('CoreSystem.dashboard.index');
})->name('dashboard');