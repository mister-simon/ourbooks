<?php

use App\Helpers\ShelfUserSession;
use function Livewire\Volt\{computed, state, rules};

state([
    'shelf' => fn() => $shelf,
    'user' => null,
]);

rules([
    'user' => 'string|min:1',
]);

$name = computed(fn() => ShelfUserSession::get($this->shelf));

$setUser = fn($user) => ShelfUserSession::set($this->shelf, $user);

$addUser = function () {
    $data = $this->validate();

    $this->shelf->addUser($this->user);
    $this->shelf->save();
};

?>
<x-layouts.app :title="'OurBooks - ' . $shelf->title">
    <div class="relative flex min-h-screen bg-gray-100 bg-center sm:items-center sm:justify-center">
        <main class="pb-8">
            @volt('shelf.index')
                <div>
                    <h1 class="mb-8 text-2xl"> {{ $shelf->title }}</h1>

                    <p>Hello, <em>{{ $this->name }}</em>. Maybe add some friends below?</p>

                    <div class="my-4 rounded-xl border border-primary-300 bg-slate-200 px-4 py-3">
                        <form wire:submit="addUser">
                            <div>
                                <input type="text" wire:model="user" id="user" placeholder="Tone" />
                                <x-button type="submit">Add</x-button>
                                @error('user')
                                    <p>{{ $message }}</p>
                                @enderror

                            </div>
                        </form>
                    </div>

                    @unless ($shelf->users->containsOneItem())
                        <div class="my-4 rounded-xl border border-primary-300 bg-slate-200 px-4 py-3">
                            <p class="text-sm">Not {{ $this->name }}?</p>

                            @foreach ($shelf->users as $user)
                                @continue($user === $this->name)
                                <x-button wire:click="setUser('{{ $user }}')">{{ $user }}</x-button>
                            @endforeach
                        </div>
                    @endunless

                </div>
            @endvolt

        </main>
    </div>
</x-layouts.app>
