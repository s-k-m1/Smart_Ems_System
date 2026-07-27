<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\PasswordReset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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

        $token = $this->argument('token');
        $url = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        $logPath = storage_path('logs/reset-urls.log');
        file_put_contents($logPath, date('Y-m-d H:i:s') . " | User: {$user->id} | Email: {$user->email} | URL: $url\n", FILE_APPEND);

        try {
            $user->notify(new PasswordReset($token));
            $this->info('Sent to ' . $user->email);
        } catch (\Throwable $e) {
            file_put_contents($logPath, "FAILED: " . $e->getMessage() . "\n", FILE_APPEND);
            $this->error($e->getMessage());
        }

        return 0;
    }
}
