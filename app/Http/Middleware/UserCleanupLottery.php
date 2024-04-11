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
        $this->incrementCount('handle');

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        if ($this->isLotteryWinner() === false || $this->wasCheckedRecently()) {
            $this->incrementCount('terminated');

            return;
        }

        $this->wasCheckedRecently(true);
        $this->incrementCount('cleaned');

        Artisan::call(UserCleanup::class);
    }

    protected function isLotteryWinner(): bool
    {
        return Lottery::odds(1, 50)->choose();
    }

    protected function wasCheckedRecently($set = null): bool
    {
        $key = $this->getCacheKey('was-checked-recently');

        if ($set === null) {
            return (bool) Cache::get($key, false);
        }

        return Cache::put($key, true, now()->addHour());
    }

    protected function incrementCount(string $key)
    {
        Cache::add($this->getCacheKey($key), 0);
        Cache::increment($this->getCacheKey($key));
    }

    protected function getCacheKey(string $key): string
    {
        return implode('-', [static::class, $key]);
    }
}
