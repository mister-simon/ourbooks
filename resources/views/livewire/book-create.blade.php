<?php

use App\Models\Book;
use function Livewire\Volt\{state, computed, rules, updated};
use Illuminate\Support\Arr;

state(['shelf' => fn() => $shelf])->locked();
state(['series', 'series_index', 'author_surname', 'author_forename', 'title', 'genre', 'edition', 'co_author']);

rules([
    'series' => ['nullable', 'string'],
    'series_index' => ['nullable', 'integer', 'min:0'],
    'author_surname' => ['nullable', 'string'],
    'author_forename' => ['nullable', 'string'],
    'title' => ['required', 'string'],
    'genre' => ['nullable', 'string'],
    'edition' => ['nullable', 'string'],
    'co_author' => ['nullable', 'string'],
]);

$create = function () {
    $this->authorize('create', [Book::class, $this->shelf]);

    $data = $this->validate();
    $data = Arr::map($data, fn($value) => $value === '' ? null : $value);

    $book = $this->shelf->books()->create($data);
    $this->dispatch('book-created', book: $book->id);

    $shelf = $this->shelf;
    $this->reset();
    $this->shelf = $shelf;
};

$dispatchSearch = function () {
    $data = $this->only(['series', 'author_surname', 'author_forename', 'title', 'co_author']);

    $this->dispatch('book-filter', filter: ['search' => Arr::join(array_filter($data), ' or ')]);
};

updated(
    collect(['series', 'author_surname', 'author_forename', 'title', 'co_author'])
        ->flip()
        ->map(fn() => fn() => $this->dispatchSearch())
        ->all(),
);

?>

<div>
    <x-subtitle>
        New Book
    </x-subtitle>

    <form wire:submit="create">
        <div class="grid grid-cols-4 gap-2">
            <x-text-input name="title" wire:model.live.debounce="title" />
            <x-text-input name="author_surname" wire:model.live.debounce="author_surname" />
            <x-text-input name="author_forename" wire:model.live.debounce="author_forename" />
            <x-text-input name="co_author" wire:model.live.debounce="co_author" />
            <x-genre-input name="genre" wire:model.live.debounce="genre" />
            <x-text-input name="series" wire:model.live.debounce="series" />
            <x-number-input name="series_index" wire:model.live.debounce="series_index" />
            <x-text-input name="edition" wire:model.live.debounce="edition" />
        </div>

        <x-button type="submit">Add Book</x-button>
    </form>
</div>
