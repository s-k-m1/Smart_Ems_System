<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('CoreSystem.dashboard.index');
    }

    public function admin()
    {
        return view('CoreSystem.dashboard.admin');
    }

    public function hr()
    {
        return view('CoreSystem.dashboard.hr');
    }

    public function employee()
    {
        return view('CoreSystem.dashboard.employee');
    }
}
