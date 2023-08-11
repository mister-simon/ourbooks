<?php

use App\Models\User;
use App\Notifications\LoginLink;
use function Livewire\Volt\{state, rules};

state(['shelf' => fn() => $shelf]);

state(['email']);
rules(['email' => ['required', 'email']]);

state(['sent' => false]);

$submit = function () {
    $data = $this->validate();

    $user = User::firstOrCreate($data);
    $user->notify(new LoginLink());

    $this->shelf->users()->syncWithoutDetaching([$user->id]);

    $this->sent = true;
};

?>

<div>
    @if ($this->sent)
        <div class="bg-emerald-100 p-4">
            <p>Success! Your friend has been added and sent a login link!</p>
        </div>
    @else
        <form wire:submit="submit">
            <x-email-input
                wire:model="email"
                label="Their Email"
                placeholder="simon@example.com"
                autofocus />

            <x-button type="submit">Add Friend</x-button>
        </form>
    @endif
</div>
