<?php

use App\Models\Shelf;
use function Livewire\Volt\{state, rules};

state(['user' => fn() => Auth::user()]);
state(['title']);
rules(['title' => ['required', 'string']]);

$create = function () {
    $data = $this->validate();

    $shelf = Shelf::create($data);
    $shelf->users()->syncWithoutDetaching([$this->user->id]);

    return $this->redirect(route('shelf', ['shelf' => $shelf]));
};

?>

<div>
    <form wire:submit="create">
        <x-text-input
            wire:model="title"
            name="title"
            label="Shelf Title" />

        <x-button type="submit">Build a New Shelf</x-button>
    </form>
</div>
