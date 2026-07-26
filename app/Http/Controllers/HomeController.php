<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            } elseif ($user->isHr()) {
                return redirect('/hr/dashboard');
            }
            return redirect('/employee/dashboard');
        }
        return redirect('/login');
    }

    public function detail()
    {
        return view('EmployeDetail.index');
    }
}
