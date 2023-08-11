<?php

use App\Http\Middleware\RequireUserName;
use function Laravel\Folio\{middleware};

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
            @else
                <livewire:login-link />
            @endauth
        </x-well>
    </x-main>
</x-layouts.app>
