<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;
use Spatie\Honeypot\Events\SpamDetectedEvent;

class LogSpamDetectedEvent
{
    public function handle(SpamDetectedEvent $event): void
    {
        $request = $event->request;

        // Log the number of infractions
        Cache::increment(static::class.'-'.$request->fingerprint().'-count');

        // Log the latest infraction's info
        Cache::put(
            static::class.'-'.$request->fingerprint(),
            [
                $request->fullUrl(),
                $request->all(),
                $request->header(),
                $request->ips(),
            ]
        );
    }
}