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
            return redirect('/forgot-password')->withErrors(['email' => "We can't find a user with that email address."]);
        }

        $token = Password::createToken($user);

        $artisan = base_path('artisan');
        $uid = $user->id;
        $etok = escapeshellarg($token);
        $log = storage_path('logs/email-' . $uid . '.log');
        $cmd = "php \"$artisan\" ems:send-reset $uid $etok > \"$log\" 2>&1 &";
        exec($cmd);

        return redirect('/forgot-password')->with('status', 'We have emailed your password reset link!');
    }
}
