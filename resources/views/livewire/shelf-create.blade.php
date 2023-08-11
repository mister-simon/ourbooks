<?php

use function Livewire\Volt\{state};

?>

<div>
    <form wire:submit="create">
        <x-text-input name="title" label="Shelf Title" />

        <x-button type="submit">Build a New Shelf</x-button>
    </form>
</div>
