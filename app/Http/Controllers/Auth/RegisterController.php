<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('CoreSystem.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_EMPLOYEE,
        ]);

        $last = Employee::where('employee_id', 'like', 'EMP%')
            ->orderByDesc('employee_id')
            ->value('employee_id');

        $next = $last ? 'EMP' . str_pad(((int) substr($last, 3)) + 1, 3, '0', STR_PAD_LEFT) : 'EMP001';

        Employee::create([
            'user_id'      => $user->id,
            'employee_id'  => $next,
            'name'         => $request->name,
            'department'   => 'Engineering',
            'position'     => 'Junior Developer',
            'status'       => 'Active',
            'email'        => $request->email,
            'phone'        => '555-0000',
            'joined'       => now()->toDateString(),
            'address'      => '—',
            'present_days' => 0,
            'leave_taken'  => 0,
            'salary'       => 0.00,
            'projects'     => 0,
        ]);

        Auth::login($user);

        return redirect('/employee/dashboard');
    }
}
