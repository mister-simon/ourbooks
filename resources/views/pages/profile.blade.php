<?php

use App\Http\Middleware\Authenticate;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules, updated};
use Illuminate\Validation\Rule;

name('profile');
middleware([Authenticate::class]);

state(['user' => fn() => Auth::user()]);
state(['name' => fn() => $this->user->name]);
state(['email' => fn() => $this->user->email]);
state(['success' => false]);

updated(['email' => fn() => ($this->success = false)]);
updated(['name' => fn() => ($this->success = false)]);

rules([
    'name' => ['required', 'string'],
    'email' => [
        'required',
        'email',
        'lowercase',
        Rule::unique('users')
            ->when(Auth::user())
            ->ignoreModel(Auth::user()),
    ],
]);

$create = function () {
    $data = $this->validate();

    $hadName = $this->user->name !== null;

    $this->user->update($data);

    $this->dispatch('profile-update');
    $this->success = true;

    if ($hadName === false) {
        $this->redirect('/');
    }
};

?>
<x-layouts.app title="Profile">
    <x-main>
        @if (session()->has('status'))
            <div class="bg-emerald-100 p-4">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        @volt('profile')
            <x-card class="w-auto">
                <x-subtitle>Profile</x-subtitle>

                @if ($this->success)
                    <div class="bg-emerald-100 p-4">
                        <p>Successfully updated</p>
                    </div>
                @endif
                <form wire:submit="create">
                    <x-text-input
                        wire:model.live="name"
                        name="name"
                        label="Name" />

                    <x-email-input
                        wire:model.live="email"
                        name="email"
                        label="Email" />

                    <x-button type="submit">Save</x-button>
                </form>
            </x-card>
        @endvolt
    </x-main>
</x-layouts.app>
