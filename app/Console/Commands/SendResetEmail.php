<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\PasswordReset;
use Illuminate\Console\Command;

class SendResetEmail extends Command
{
    protected $signature = 'ems:send-reset {userId} {token}';
    protected $description = 'Send password reset email';

    public function handle(): int
    {
        $user = User::find($this->argument('userId'));
        if (!$user) {
            $this->error('User not found');
            return 1;
        }
        try {
            $user->notify(new PasswordReset($this->argument('token')));
            $this->info('Sent to ' . $user->email);
            return 0;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
