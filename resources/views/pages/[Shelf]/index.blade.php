<?php

use App\Http\Middleware\RequireUserName;
use function Laravel\Folio\{middleware};
use function Livewire\Volt\{computed, state, rules};

middleware([RequireUserName::class]);

state(['shelf' => fn() => $shelf]);

$addUser = function () {
    $data = $this->validate();

    $this->shelf->addUser($this->user);
    $this->shelf->save();
};

?>
<x-layouts.app :title="$shelf->title">
    <x-main>
        @volt('shelf.index')
            <div>
                @persist('shelf-list')
                    <livewire:shelf-list />
                @endpersist

                <x-well>
                    <x-title>{{ $shelf->title }}</x-title>

                    @if ($this->name)
                        <p>Hello, <em>{{ $this->name }}</em>.</p>
                    @endif

                    @if ($this->name)
                        <p> Maybe add some friends below?</p>

                        <form wire:submit="addUser">
                            <div>
                                <input type="text" wire:model="user" id="user" placeholder="Tone" />

                                <x-button type="submit">Add Friend</x-button>

                                @error('user')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </form>
                    @endif

                    @unless ($shelf->users->containsOneItem() || $this->name !== null)
                        <div class="mt-4">
                            @if ($this->name)
                                <p class="text-sm">Not {{ $this->name }}?</p>
                            @else
                                <p class="text-sm">Who are you?</p>
                            @endif

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
