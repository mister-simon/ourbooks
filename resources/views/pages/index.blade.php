<?php

?>
<x-layouts.app title="Home">
    <livewire:header />

    <x-main>
        <x-well>
            <h1 class="mb-8 text-2xl">{{ config('app.name') }}</h1>

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
