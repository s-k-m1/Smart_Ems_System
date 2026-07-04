<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(function () {
                require __DIR__.'/../routes/CoreSystem/core.routes.php';
                require __DIR__.'/../routes/AttendanceLeave/attendance.routes.php';
                require __DIR__.'/../routes/EmployeeManagement/employee.routes.php';
                require __DIR__.'/../routes/PayrollReport/payroll.routes.php';
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();