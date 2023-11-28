<?php

namespace App\Listeners;

use App\Models\ShelfInvite;
use Illuminate\Auth\Events\Verified;

class AttachShelfInvitesToVerifiedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        ShelfInvite::where('email', $user->email)
            ->update(['user_id' => $user->id]);
    }
}
