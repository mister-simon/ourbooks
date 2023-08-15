<?php

use App\Models\User;
use App\Notifications\ShelfInvitation;
use function Livewire\Volt\{state, rules};

state(['shelf' => fn() => $shelf]);
state(['user' => fn() => Auth::user()]);

state(['email']);
rules(['email' => ['required', 'email', 'lowercase']]);

state(['sent' => false]);

$submit = function () {
    $data = $this->validate();

    $user = User::firstOrCreate($data);
    $user->notify(new ShelfInvitation(shelf: $this->shelf, user: $this->user));

    $this->shelf->users()->syncWithoutDetaching([$user->id]);

    $this->sent = true;
    $this->email = null;

    $this->dispatch('shelf-user-added', id: $this->shelf->id);
};

?>

<div>
    @if ($this->sent)
        <div class="bg-emerald-100 p-4">
            <p>Success! Your friend has been added and sent a login link!</p>
        </div>
    @endif

    <form wire:submit="submit">
        <x-email-input
            wire:model="email"
            name="email"
            label="Their Email"
            placeholder="simon@example.com"
            autofocus />

        <x-button type="submit">Add Friend</x-button>
    </form>
</div>
