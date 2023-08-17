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
        <div class="grid grid-cols-4 gap-2">
            <x-text-input name="search" wire:model.live.debounce="search" />
        </div>

        <x-button type="submit" class="hidden">Search</x-button>
    </form>
</div>
