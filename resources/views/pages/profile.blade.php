<?php

use function Laravel\Folio\{middleware};
use function Livewire\Volt\{state, rules};
use Illuminate\Validation\Rule;

middleware(['auth']);

state(['user' => fn() => Auth::user()]);
state(['name' => fn() => $this->user->name]);
state(['email' => fn() => $this->user->email]);

rules([
    'name' => ['required', 'string'],
    'email' => ['required', 'email', Rule::unique('users')->ignoreModel(Auth::user())],
]);

$create = function () {
    $data = $this->validate();

    $this->user->update($data);

    $this->dispatch('profile-update');
};

?>
<x-layouts.app title="Profile">
    <livewire:header />

    <x-main>
        @if (session()->has('status'))
            <div class="bg-emerald-100 p-4">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <x-well>
            @volt('profile')
                <form wire:submit="create">
                    <x-text-input
                        wire:model="name"
                        name="name"
                        label="Name" />

                    <x-email-input
                        wire:model="email"
                        name="email"
                        label="Email" />

                    <x-button type="submit">Save</x-button>
                </form>
            @endvolt
        </x-well>
    </x-main>
</x-layouts.app>
