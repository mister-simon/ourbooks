<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RequireUserName;
use App\Models\Book;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{computed, state, rules, on};
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Arr;

name('shelf');
middleware([Authenticate::class, RequireUserName::class]);
middleware([Authorize::using('view', 'shelf')]);

state(['shelf' => fn() => $shelf]);
state(['user' => fn() => Auth::user()]);
state(['state' => fn() => $this->shelf->books->isEmpty() ? 'create' : 'filter']);
state(['search' => null]);

$books = computed(
    fn() => $this->shelf
        ->books()
        ->orderBy('author_surname')
        ->orderBy('author_forename')
        ->orderBy('series')
        ->orderBy('series_index')
        ->orderBy('title')
        ->when($this->filterIds !== null, fn($query) => $query->whereIn('id', $this->filterIds))
        ->get(),
);

$filterIds = computed(function () {
    if (!$this->search) {
        return null;
    }

    return str($this->search)
        ->explode(' or ')
        ->map(
            fn($searchPart) => Book::search($searchPart)
                ->where('shelf_id', $this->shelf->id)
                ->keys(),
        )
        ->flatten()
        ->unique();
});

on(['shelf-user-added' => fn() => $this->shelf->load('users')]);
on(['book-created' => fn() => $this->shelf->refresh()]);
on(['book-filter' => fn($filter) => ($this->search = $filter['search'] ?? null)]);

?>
<x-layouts.app :title="$shelf->title">
    <x-main class="container mx-auto !items-start">
        @volt('shelf.index')
            <div class="w-full space-y-4">
                <x-card class="rounded-t-none">
                    <livewire:shelf-list />
                </x-card>

                <x-card>
                    <x-title>{{ $shelf->title }}</x-title>

                    <p class="pb-4">This shelf belongs to {{ $shelf->userListString() }}</p>

                    <p> Maybe add some friends below?</p>

                    <livewire:shelf-user-add :shelf="$this->shelf" />
                </x-card>

                <x-card>
                    <div>
                        <div class="overflow-hidden">
                            <x-button
                                wire:click="$set('state', 'create')"
                                class="{{ $this->state !== 'create' ? 'opacity-70' : '' }} rounded-b-none">
                                Create
                            </x-button>
                            <x-button
                                wire:click="$set('state', 'filter')"
                                class="{{ $this->state !== 'filter' ? 'opacity-70' : '' }} rounded-b-none">
                                Filter
                            </x-button>
                        </div>

                        <x-hr class="mt-0 border-t-4 border-primary-500" />

                        @if ($this->state === 'create')
                            <livewire:book-create :shelf="$shelf" />
                        @endif

                        @if ($this->state === 'filter')
                            <livewire:book-filter :search="$this->search" />
                        @endif
                    </div>

                    <x-hr />

                    @if ($this->search)
                        <div class="flex justify-between">
                            <p>{{ $this->books->count() }} results for search "{{ $this->search }}".</p>
                            <x-button wire:click="$dispatch('book-filter', { filter: {search: null} })">Clear Search</x-button>
                        </div>
                    @endif

                    <livewire:book-list
                        :books="$this->books"
                        :key="'books-' . $this->search . '-' . $this->books->count()" />
                </x-card>
            </div>
        @endvolt
    </x-main>
</x-layouts.app>
