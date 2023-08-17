<?php

use App\Models\Book;
use function Livewire\Volt\{state, rules, updated, on};

state(['search' => fn() => $search]);
rules(['search' => ['nullable', 'string']]);

$filter = function () {
    $data = $this->validate();

    $this->dispatch('book-filter', filter: $this->all());
};

updated(['search' => fn() => $this->filter()]);

?>

<div>
    <form wire:submit="filter">
        <div class="flex items-center">
            <x-text-input name="search" wire:model.live.debounce="search" />

            <x-button
                type="submit"
                class="ml-2 mt-2 inline-flex h-11 flex-row items-center gap-2">
                @svg('heroicon-o-magnifying-glass', 'w-4 h-4') Search
            </x-button>
        </div>
    </form>
</div>
