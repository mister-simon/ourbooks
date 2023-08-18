<?php

use App\Http\Middleware\RequireUserName;
use App\Models\User;
use function Laravel\Folio\{middleware, name};

name('home');
middleware([RequireUserName::class]);

?>
<x-layouts.app title="Home">
    <x-main>
        <x-card class="w-auto">
            @auth
                @persist('shelf-list')
                    <livewire:shelf-list />
                @endpersist

                <x-hr />

                <livewire:shelf-create />
            @else
                <livewire:login-link />

                @env('local')
                <div class="mt-8 space-y-4 rounded-lg bg-slate-300 p-4 text-center text-xs">
                    <p>Local Env Only:</p>
                    <x-link :href="URL::signedRoute('auth.login', ['user' => ($user = User::first())])">
                        Login as {{ $user->name }}
                    </x-link>
                </div>
                @endenv
            @endauth
        </x-card>
    </x-main>
</x-layouts.app>
