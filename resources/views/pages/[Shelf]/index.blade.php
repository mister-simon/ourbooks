<?php

use App\Helpers\ShelfUserSession;
use function Livewire\Volt\{computed, state, rules};

state([
    'shelf' => fn() => $shelf,
    'user' => null,
]);

rules([
    'user' => 'required|string|min:1',
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
    <x-main>
        @volt('shelf.index')
            <div>
                @persist('shelf-list')
                    <livewire:shelf-list />
                @endpersist

                <x-well>
                    <x-title>{{ $shelf->title }}</x-title>

                    <p>Hello, <em>{{ $this->name }}</em>. Maybe add some friends below?</p>

                    <form wire:submit="addUser">
                        <div>
                            <input type="text" wire:model="user" id="user" placeholder="Tone" />

                            <x-button type="submit">Add Friend</x-button>

                            @error('user')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </form>

                    @unless ($shelf->users->containsOneItem())
                        <div class="mt-4">
                            <p class="text-sm">Not {{ $this->name }}?</p>

                            <div class="flex flex-wrap gap-2 pt-2">
                                @foreach ($shelf->users as $user)
                                    @continue($user === $this->name)
                                    <x-button wire:click="setUser('{{ $user }}')">{{ $user }}</x-button>
                                @endforeach
                            </div>
                        </div>
                    @endunless
                </x-well>

                <x-well>
                    <livewire:book-create :shelf="$shelf" />
                </x-well>

            </div>
        @endvolt
    </x-main>
</x-layouts.app>
