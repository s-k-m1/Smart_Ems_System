<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordReset;
use App\Notifications\PlainPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('CoreSystem.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->showLinkRequestForm();
        }

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response('USER NOT FOUND', 200);
        }

        return response('USER FOUND: ' . $user->name . ' | Email: ' . $user->email, 200);
    }
}
