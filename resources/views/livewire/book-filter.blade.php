<?php

use App\Models\Book;
use function Livewire\Volt\{state, rules, updated};

state(['series', 'series_index', 'author_surname', 'author_forename', 'title', 'genre', 'edition', 'co_author']);

rules([
    'series' => ['nullable', 'string'],
    'series_index' => ['nullable', 'integer', 'min:0'],
    'author_surname' => ['nullable', 'string'],
    'author_forename' => ['nullable', 'string'],
    'title' => ['nullable', 'string'],
    'genre' => ['nullable', 'string'],
    'edition' => ['nullable', 'string'],
    'co_author' => ['nullable', 'string'],
]);

$filter = function () {
    $data = $this->validate();

    $this->dispatch('book-filter', filter: $this->all());
};

updated([
    'series' => fn() => $this->filter(),
    'series_index' => fn() => $this->filter(),
    'author_surname' => fn() => $this->filter(),
    'author_forename' => fn() => $this->filter(),
    'title' => fn() => $this->filter(),
    'genre' => fn() => $this->filter(),
    'edition' => fn() => $this->filter(),
    'co_author' => fn() => $this->filter(),
]);

?>

<div>
    <x-subtitle>
        Search
    </x-subtitle>

    <form wire:submit="filter">
        <div class="grid grid-cols-4 gap-2">
            <x-text-input name="title" wire:model.live="title" />
            <x-text-input name="author_surname" wire:model.live="author_surname" />
            <x-text-input name="author_forename" wire:model.live="author_forename" />
            <x-text-input name="co_author" wire:model.live="co_author" />
            <x-genre-input name="genre" wire:model.live="genre" />
            <x-text-input name="series" wire:model.live="series" />
            <x-number-input name="series_index" wire:model.live="series_index" />
            <x-text-input name="edition" wire:model.live="edition" />
        </div>

        <x-button type="submit">Search</x-button>
    </form>
</div>
