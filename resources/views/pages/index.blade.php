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
    'title' => ['string', 'min:1'],
    'user' => ['string', 'min:1'],
]);

$create = function () {
    $data = $this->validate();

    $shelf = Shelf::create($data);
    ShelfUserSession::set($shelf, $this->user);

    $this->redirect($shelf->getUrl());
};

?>
<x-layouts.app title="Welcome!">
    <div class="relative flex min-h-screen bg-gray-100 bg-center sm:items-center sm:justify-center">
        <main class="pb-8">
            <h1 class="mb-8 text-2xl">OurBooks</h1>

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
        </main>
    </div>
</x-layouts.app>
