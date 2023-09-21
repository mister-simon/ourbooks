<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhitelistIps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = config('whitelist-ips.list');

        // Ignore empty whitelist
        if (count($whitelist) === 0) {
            return $next($request);
        }

        // Otherwise check against it
        $ip = request()->ip();

        if (app()->isProduction() && ! session('whitelisted')) {
            abort_unless(
                in_array($ip, $whitelist),
                403,
                "Your IP ({$ip}) is not authorized."
            );
        }

        session()->put('whitelisted', true);

        return $next($request);
    }
}
