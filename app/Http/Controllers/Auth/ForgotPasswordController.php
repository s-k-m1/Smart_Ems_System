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
            return redirect('/forgot-password')->withErrors(['email' => "We can't find a user with that email address."]);
        }

        $token = Password::createToken($user);
        $url = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        $phpPath = PHP_BINARY ?: 'php';
        $artisan = base_path('artisan');
        $cmd = escapeshellcmd($phpPath) . ' ' . escapeshellarg($artisan) . ' ems:send-reset ' . escapeshellarg($user->id) . ' ' . escapeshellarg($token);
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            $wsh = new \COM('WScript.Shell');
            $wsh->Run($cmd, 0, false);
        } else {
            exec($cmd . ' > /dev/null 2>&1 &');
        }

        return redirect('/forgot-password')->with('status', "We have emailed your password reset link! If you don't see it, <a href='$url' class='underline'>click here</a>.");
    }
}
