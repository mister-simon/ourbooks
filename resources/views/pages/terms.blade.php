<?php

use function Laravel\Folio\{name};

name('terms');

?>
<x-layouts.app title="Home" :hide-sidebar="Auth::guest()">
    @auth
        <x-app-card title="Build a New Shelf" class="card-bordered">
            <livewire:shelf-create />
        </x-app-card>
    @else
        <x-app-card class="card-bordered">
            @include('partials.terms-md')
        </x-app-card>
    @endauth
</x-layouts.app>
