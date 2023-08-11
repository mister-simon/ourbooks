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
    'email' => ['required', 'email'],
])->attributes([
    'user' => 'name',
]);

$create = function () {
    $data = $this->validate();

    $user = User::firstOrCreate($data['user']);
    $shelf = Shelf::create($data);

    $this->redirect($shelf->getUrl());
};

$shelves = computed(fn() => ShelfUserSession::all());

?>
<x-layouts.app title="OurBooks - Home">
    <x-main>
        @persist('shelf-list')
            <livewire:shelf-list />
        @endpersist

        <x-well>
            <h1 class="mb-8 text-2xl">OurBooks</h1>

            @volt('shelf.create')
                <form wire:submit="create">
                    <x-text-input name="title" label="Shelf Title" />

                    <div class="mb-4">
                        <label for="user" class="block">Your Name</label>
                        <input type="text" wire:model="user" id="user" placeholder="Tone" />
                        @error('user')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block">Your Email</label>
                        <input type="text" wire:model="email" id="email" placeholder="tone@example.com" />
                        @error('email')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>

                    <x-button type="submit">Build a New Shelf</x-button>
                </form>
            @endvolt
        </x-well>
    </x-main>
</x-layouts.app>
