<?php

use App\Http\Middleware\RequireUserName;
use App\Models\User;
use function Laravel\Folio\{middleware, name};

name('home');
middleware([RequireUserName::class]);

?>
<x-layouts.app title="Home" :hide-sidebar="Auth::guest()">
    @auth
        <x-app-card title="Build a New Shelf" class="card-bordered">
            <livewire:shelf-create />
        </x-app-card>
    @else
        <x-app-card class="card-bordered">
            <livewire:login-link />

            @env('local')
            <div class="mt-8 space-y-4 rounded-lg bg-slate-300 p-4 text-center text-xs dark:bg-slate-800">
                <p>Local Env Only:</p>
                <x-link :href="URL::signedRoute('auth.login', ['user' => ($user = User::first())])">
                    Login as {{ $user->name }}
                </x-link>
            </div>
            @endenv
        </x-app-card>
    @endauth
</x-layouts.app>
