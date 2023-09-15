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
        $ip = request()->ip();

        if (app()->isProduction() && ! session('whitelisted')) {
            abort_unless(
                in_array($ip, config('whitelist-ips.list')),
                403,
                "Your IP ({$ip}) is not authorized."
            );
        }

        session()->put('whitelisted', true);

        return $next($request);
    }
}
