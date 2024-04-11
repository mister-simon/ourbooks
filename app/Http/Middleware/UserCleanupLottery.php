<?php

namespace App\Http\Middleware;

use App\Console\Commands\UserCleanup;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Lottery;
use Symfony\Component\HttpFoundation\Response;

class UserCleanupLottery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Cache::increment($this->getCacheKey().'-handled');

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        Cache::increment($this->getCacheKey().'-lotteries');

        $lottery = Lottery::odds(1, 50)
            ->choose();

        $cacheKey = $this->getCacheKey();

        if ($lottery === false || Cache::get($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, now()->addHour());

        Artisan::call(UserCleanup::class);
    }

    protected function getCacheKey(): string
    {
        return static::class;
    }
}
