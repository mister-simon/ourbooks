<?php

use function Livewire\Volt\{state, rules};

state(['email']);
rules(['email' => ['required', 'email']]);

$submit = function () {
    $this->validate();

    $user = User::firstOrCreate($data['user']);
};

?>

<div>
    <form wire:submit="submit">
        <x-subtitle>Get a login link</x-subtitle>

        <x-email-input
            wire:model="email"
            label="Your Email"
            placeholder="tone@example.com" />

        <x-button type="submit">Build a New Shelf</x-button>
    </form>
</div>
