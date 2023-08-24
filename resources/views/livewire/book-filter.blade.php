<?php

use App\Models\Book;
use function Livewire\Volt\{state, rules, updated, booted, on};

state(['search'])->url();
rules(['search' => ['nullable', 'string']]);

$filter = function () {
    $data = $this->validate();

    $this->dispatch('book-filter', filter: $this->all());
};

updated(['search' => fn() => $this->filter()]);
// booted(fn() => $this->filter());

on([
    'book-filter-search' => function ($search) {
        $this->search = $search;
        $this->filter();
    },
    'book-filter-refresh' => function () {
        $this->filter();
    },
]);

?>

<div>
    <form wire:submit="filter">
        <div class="flex items-center gap-2">
            <x-text-input name="search" wire:model.live.debounce="search" />

            <x-button
                type="submit"
                class="inline-flex flex-row items-center gap-2">
                @svg('heroicon-o-magnifying-glass', 'w-4 h-4') Search
            </x-button>
        </div>
    </form>
</div>
