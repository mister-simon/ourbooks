<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans user bot spam by deleting users with no verification 1 month after creation.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::query()
            ->whereNull('email_verified_at')
            ->where('created_at', '<', now()->subMonth())
            ->each(fn (User $user) => $user->delete());
    }
}
