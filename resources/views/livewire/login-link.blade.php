<?php

use App\Models\User;
use App\Notifications\LoginLink;
use function Livewire\Volt\{state, rules};

state(['email']);
rules(['email' => ['required', 'email', 'lowercase']]);

state(['sent' => false]);

$submit = function () {
    $data = $this->validate();

    $user = User::firstOrCreate($data);
    $user->notify(new LoginLink());

    $this->sent = true;
};

?>

<div>
    @if ($this->sent)
        <x-alert-success>
            <p>Success! Check your emails for your login link!</p>
        </x-alert-success>
    @else
        <form wire:submit="submit">
            <x-email-input
                name="email"
                wire:model="email"
                label="Your Email"
                placeholder="tone@example.com"
                autofocus />

            <x-button type="submit">Send Login Link</x-button>
        </form>
    @endif
</div>
