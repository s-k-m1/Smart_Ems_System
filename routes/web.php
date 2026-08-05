<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/report', [ReportController::class, 'index'])
        ->name('report.index')
        ->middleware('permission:view_reports');
});

Route::get('/reset-log', function () {
    $log = storage_path('logs/reset-urls.log');
    if (!file_exists($log)) {
        return 'No log file yet';
    }
    return '<pre>' . htmlspecialchars(file_get_contents($log)) . '</pre>';
});

Route::get('/docs/report', function () {
    $path = base_path('Smart_EMS_System_Report.pdf');
    if (!file_exists($path)) {
        abort(404, 'Report not found.');
    }
    return response()->download($path, 'Smart_EMS_System_Report.pdf');
})->name('docs.report');

Route::get('/docs/report/doc', function () {
    $path = base_path('Smart_EMS_System_Report.docx');
    if (!file_exists($path)) {
        abort(404, 'Report not found.');
    }
    return response()->download($path, 'Smart_EMS_System_Report.docx');
})->name('docs.report.doc');
