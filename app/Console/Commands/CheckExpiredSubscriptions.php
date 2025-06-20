<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Check and update expired subscriptions';

    public function handle()
    {
        $users = User::where('is_premium', true)
                    ->whereNotNull('subscription_expires_at')
                    ->get();

        foreach ($users as $user) {
            $user->checkAndUpdateSubscription();
        }

        $this->info('Successfully checked subscription expiration status.');
    }
} 