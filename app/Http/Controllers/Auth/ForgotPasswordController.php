<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        app()->terminating(function () use ($user, $token) {
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
            $user->sendPasswordResetNotification($token);
        });

        return back()->with(['status' => 'We have emailed your password reset link!']);
    }
}
