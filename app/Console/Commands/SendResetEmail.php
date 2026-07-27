<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\PasswordReset;
use Illuminate\Console\Command;

class SendResetEmail extends Command
{
    protected $signature = 'ems:send-reset {userId} {token}';
    protected $description = 'Send password reset email to a user';

    public function handle(): int
    {
        $userId = $this->argument('userId');
        $token = $this->argument('token');

        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        try {
            $user->notify(new PasswordReset($token));
            $this->info('Email sent to ' . $user->email);
            return 0;
        } catch (\Throwable $e) {
            $this->error('Failed: ' . $e->getMessage());
            return 1;
        }
    }
}
