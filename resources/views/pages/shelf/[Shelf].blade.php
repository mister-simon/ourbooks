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
                        <div class="overflow-hidden">
                            <x-button
                                wire:click="$set('state', 'create')"
                                class="rounded-b-none {{$this->state !== 'create' ? 'opacity-70' : ''}}">
                                Create
                            </x-button>
                            <x-button
                                wire:click="$set('state', 'filter')"
                                class="rounded-b-none {{$this->state !== 'filter' ? 'opacity-70' : ''}}">
                                Filter
                            </x-button>

                        </div>

                        <x-hr class="mt-0 border-t-4 border-primary-500" />

                        @if ($this->state === 'create')
                            <livewire:book-create :shelf="$shelf" />
                        @endif

                        @if ($this->state === 'filter')
                            <livewire:book-filter />
                        @endif
                    </div>

                    <x-hr />

                    @forelse ($this->books as $book)
                        @if ($loop->first)
                            <div class="mt-4 ml-6 space-y-4">
                        @endif

                        <div @class([
                            'px-2 relative',
                            'border-primary-800 border-l-2' => $isNewSurnameChar = ($prev = $this->books[$loop->index - 1] ?? null) === null || ($prev->authorSurnameChar !== $book->authorSurnameChar)
                        ])>
                            @if ($isNewSurnameChar)
                                <div class="absolute top-0 right-full p-2 leading-none bg-primary-800 text-white text-xs font-mono">
                                    {{ $book->authorSurnameChar }}
                                </div>
                            @endif
                            <h2>
                                <span class="font-semibold">
                                    {{ $book->title }}
                                </span> - {{ $book->authorName }}
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

                        @if ($loop->last)
                            </div>
                        @endif
                    @empty
                        <p>No books yet.</p>
                    @endforelse
                </x-well>
            </div>
        @endvolt
    </x-main>
</x-layouts.app>
