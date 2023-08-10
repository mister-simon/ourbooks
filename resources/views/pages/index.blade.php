<?php

use App\Helpers\ShelfUserSession;
use App\Models\Shelf;
use function Livewire\Volt\{state, rules, computed};
use Illuminate\Support\Facades\URL;

state([
    'title' => null,
    'user' => null,
]);

rules([
    'title' => ['required', 'string', 'min:1'],
    'user' => ['required', 'string', 'min:1'],
])->attributes([
    'user' => 'name',
]);

$create = function () {
    $data = $this->validate();

    $shelf = Shelf::create($data);
    ShelfUserSession::set($shelf, $this->user);

    $this->redirect($shelf->getUrl());
};

$shelves = computed(fn() => ShelfUserSession::all());

?>
<x-layouts.app title="Welcome!">
    <x-main>
        <h1 class="mb-8 text-2xl">OurBooks</h1>

        @persist('shelf-list')
            <livewire:shelf-list />
        @endpersist

        @volt('shelf')
            <form wire:submit="create">
                <div class="mb-4">
                    <label for="title" class="block">Shelf Title</label>
                    <input type="text" wire:model="title" id="title" placeholder="Simon + Toni's Books" />
                    @error('title')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="user" class="block">Your Name</label>
                    <input type="text" wire:model="user" id="user" placeholder="Tone" />
                    @error('user')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <x-button type="submit">Build a New Shelf</x-button>
            </form>
        @endvolt
    </x-main>
</x-layouts.app>
