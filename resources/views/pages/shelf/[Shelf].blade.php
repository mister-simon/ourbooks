<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RequireUserName;
use App\Models\Book;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{computed, state, rules, on};

name('shelf');
middleware([Authenticate::class, RequireUserName::class]);

state(['shelf' => fn() => $shelf]);
state(['user' => fn() => Auth::user()]);
state(['state' => 'filter']);
state(['filter' => null]);

$books = computed(
    fn() => $this->shelf
        ->books()
        ->orderBy('author_surname')
        ->orderBy('author_forename')
        ->orderBy('series')
        ->orderBy('series_index')
        ->orderBy('title')
        ->when(
            $this->filterIds !== null,
            fn($query) => $query->whereIn('id', $this->filterIds)
        )
        ->get()
);

$filterIds = computed(
    fn() => $this->filter
        ? Book::search($this->filter)
            ->where('shelf_id', $this->shelf->id)
            ->get()
            ->modelKeys()
        : null
);

on(['shelf-user-added' => fn() => $this->shelf->load('users')]);
on(['book-created' => fn() => ($this->shelf->refresh())]);
on(['book-filter' => fn($filter) => $this->filter = $filter['search'] ?? null]);

?>
<x-layouts.app :title="$shelf->title">
    <livewire:header />

    <x-main class="container">
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

                        <x-hr />

                        Meep

                        @if ($this->state === 'create')
                            <livewire:book-create :shelf="$shelf" />
                        @endif

                        @if ($this->state === 'filter')
                            <livewire:book-filter />
                        @endif
                    </div>

                    <x-hr />

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
