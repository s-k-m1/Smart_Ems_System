<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('CoreSystem.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => "We can't find a user with that email address."]);
        }

        $token = Password::createToken($user);

        \Illuminate\Support\Facades\Log::info('Starting email send for: ' . $user->email);

        try {
            set_time_limit(5);
            $sent = $user->notify(new PasswordReset($token));
            \Illuminate\Support\Facades\Log::info('Email sent successfully');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Email failed: ' . get_class($e) . ': ' . $e->getMessage());
        }

        return back()->with(['status' => 'We have emailed your password reset link!']);
    }
}
