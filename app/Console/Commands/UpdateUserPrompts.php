<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateUserPrompts extends Command
{
    protected $signature = 'users:update-prompts';
    protected $description = 'Update all users to have 10 prompts remaining';

    public function handle()
    {
        User::query()->update(['prompts_remaining' => 10]);
        $this->info('Successfully updated prompts for all users to 10');
    }
} 