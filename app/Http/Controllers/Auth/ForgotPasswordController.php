<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
            return redirect('/forgot-password')->withErrors(['email' => "We can't find a user with that email address."]);
        }

        $token = Password::createToken($user);
        $url = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        return redirect('/forgot-password')->with('status', "Reset link: <a href='$url' class='underline'>Click here to reset your password</a>");
    }
}
