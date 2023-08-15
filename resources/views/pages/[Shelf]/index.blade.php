<?php

use App\Http\Middleware\RequireUserName;
use function Laravel\Folio\{middleware};
use function Livewire\Volt\{computed, state, rules, on};

middleware(['auth', RequireUserName::class]);

state(['shelf' => fn() => $shelf]);
state(['user' => fn() => Auth::user()]);

on(['shelf-user-added' => fn() => $this->shelf->load('users')]);
on(['book-created' => fn() => $this->shelf->load('books')]);

?>
<x-layouts.app :title="$shelf->title">
    <livewire:header />

    <x-main>
        @volt('shelf.index')
            <div>
                <x-well>
                    <livewire:shelf-list />
                </x-well>

                <x-well>
                    <x-title>{{ $shelf->title }}</x-title>

                    <p class="pb-4">This shelf belongs to {{ $shelf->userListString() }}</p>

                    <p> Maybe add some friends below?</p>

                    <livewire:shelf-user-add :shelf="$this->shelf" />

                    @unless ($shelf->users->containsOneItem() || $this->user->name !== null)
                        <div class="mt-4">
                            @if ($this->user->name)
                                <p class="text-sm">Not {{ $this->user->name }}?</p>
                            @else
                                <p class="text-sm">Who are you?</p>
                            @endif

                            <div class="flex flex-wrap gap-2 pt-2">
                                @foreach ($shelf->users as $user)
                                    @continue($user === $this->user->name)
                                    <x-button wire:click="setUser('{{ $user }}')">{{ $user }}</x-button>
                                @endforeach
                            </div>
                        </div>
                    @endunless
                </x-well>

                <x-well>
                    <livewire:book-create :shelf="$shelf" />

                    @forelse ($shelf->books as $book)
                        {{ dump($book) && '' }}
                    @empty
                        <p>No books yet.</p>
                    @endforelse
                </x-well>
            </div>
        @endvolt
    </x-main>
</x-layouts.app>
