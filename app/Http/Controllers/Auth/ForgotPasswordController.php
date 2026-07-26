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

        try {
            $token = Password::createToken($user);
            $user->notify(new PasswordReset($token));
        } catch (\Throwable $e) {
            \Log::error('Password reset failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Could not send reset link. Please try again later.']);
        }

        return redirect()->route('password.request')->with(['status' => 'We have emailed your password reset link!']);
    }
}
