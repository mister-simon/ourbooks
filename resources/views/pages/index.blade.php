<?php

use App\Http\Middleware\RequireUserName;
use App\Models\User;
use function Laravel\Folio\{middleware, name};

name('home');
middleware([RequireUserName::class]);

?>
<x-layouts.app title="Home">
    <livewire:header />

    <x-main>
        <x-well>
            @auth
                @persist('shelf-list')
                    <livewire:shelf-list />
                @endpersist

                <x-hr />

                <livewire:shelf-create />
            @else
                <livewire:login-link />

                @env('local')
                <div class="bg-slate-300 rounded-lg p-4 mt-8 text-xs text-center space-y-4">
                    <p>Local Env Only:</p>
                    <x-link :href="URL::signedRoute('auth.login', ['user' => $user = User::first()])">
                        Login as {{$user->name}}
                    </x-link>
                </div>
                @endenv
            @endauth
        </x-well>
    </x-main>
</x-layouts.app>
