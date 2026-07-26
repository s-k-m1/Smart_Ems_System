<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Home / Root
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/detail', [HomeController::class, 'detail'])->name('EmployeDetail.index');

    // report page - admin only
    Route::get('/report', [ReportController::class, 'index'])
        ->name('report.index')
        ->middleware('role:admin');

});
