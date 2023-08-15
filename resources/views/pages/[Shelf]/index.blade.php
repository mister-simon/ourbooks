<?php

use App\Http\Middleware\RequireUserName;
use function Laravel\Folio\{middleware};
use function Livewire\Volt\{computed, state, rules, on};

middleware(['auth', RequireUserName::class]);

state(['shelf' => fn() => $shelf]);
state(['books' => fn() => $this->getBooks()]);
state(['user' => fn() => Auth::user()]);
state(['state' => 'filter']);

$getBooks = fn() => $this->shelf
    ->books()
    ->orderBy('author_surname')
    ->orderBy('author_forename')
    ->orderBy('series')
    ->orderBy('series_index')
    ->orderBy('title')
    ->get();

on(['shelf-user-added' => fn() => $this->shelf->load('users')]);
on(['book-created' => fn() => ($this->books = $this->getBooks())]);
on(['book-filter' => fn($filter) => debug($filter)]);

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
                </x-well>

                <x-well>
                    <div>
                        <x-button wire:click="$set('state', 'create')">Create</x-button>
                        <x-button wire:click="$set('state', 'filter')">Filter</x-button>

                        @if ($this->state === 'create')
                            <livewire:book-create :shelf="$shelf" />
                        @endif

                        @if ($this->state === 'filter')
                            <livewire:book-filter />
                        @endif
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-3">
                        @forelse ($this->books as $book)
                            <div>
                                <h2>
                                    <span class="font-semibold">
                                        {{ $book->title }}
                                    </span> - {{ join(' ', $book->only('author_forename', 'author_surname')) }}
                                    @if ($book->co_author)
                                        <span class="text-xs"> and {{ $book->co_author }}</span>
                                    @endif
                                </h2>

                                <div class="text-xs">
                                    @foreach ($book->only('genre', 'series_text', 'edition') as $attribute => $value)
                                        <p>{{ str($attribute)->replace('_', ' ')->title() }}: {{ $value }}</p>
                                    @endforeach

                                </div>
                            </div>
                        @empty
                            <p>No books yet.</p>
                        @endforelse

                    </div>
                </x-well>
            </div>
        @endvolt
    </x-main>
</x-layouts.app>
