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
        <x-alert-success>
            Success! Your friend has been added and sent a login link!
        </x-alert-success>
    @endif

    <form wire:submit="submit">
        <div class="flex items-center gap-2">
            <x-email-input
                wire:model="email"
                name="email"
                label="Their Email"
                placeholder="simon@example.com"
                autofocus />

            <x-button type="submit">Add Friend</x-button>
        </div>
    </form>
</div>
