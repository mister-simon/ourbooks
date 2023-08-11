<?php

use function Livewire\Volt\{state, rules};

state(['user' => fn() => Auth::user()]);
state(['name' => fn() => $this->user->name]);

rules(['name' => ['required', 'string']]);

$create = function () {
    $data = $this->validate();

    $this->user->update($data);

    return $this->redirect('/');
};

?>
<x-layouts.app title="Home">
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
                    <x-text-input wire:model="name"
                        name="name"
                        label="Your Name" />

                    <x-button type="submit">Save</x-button>
                </form>
            @endvolt
        </x-well>
    </x-main>
</x-layouts.app>
