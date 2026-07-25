<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            require __DIR__.'/../routes/CoreSystem/core.routes.php';
            require __DIR__.'/../routes/AttendanceLeave/attendance.php';
            require __DIR__.'/../routes/EmployeeManagement/employee.routes.php';
            require __DIR__.'/../routes/PayrollReport/payroll.routes.php';
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('login'));

        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            if ($user->isAdmin()) {
                return '/admin/dashboard';
            } elseif ($user->isHr()) {
                return '/hr/dashboard';
            }
            return '/employee/dashboard';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
