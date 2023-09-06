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
            <x-alert-success>
                {{ session('status') }}
            </x-alert-success>
        @endif

        @volt('profile')
            <x-card class="w-full max-w-screen-md sm:w-auto">
                <x-subtitle>Profile</x-subtitle>

                @if ($this->success)
                    <x-alert-success>
                        <p>Successfully updated</p>
                    </x-alert-success>
                @endif
                <form wire:submit="create">
                    <x-text-input
                        wire:model.live="name"
                        name="name"
                        label="Name"
                        :data-te-input-state-active="$this->name !== null" />

                    <x-email-input
                        wire:model.live="email"
                        name="email"
                        label="Email"
                        :data-te-input-state-active="$this->email !== null" />

                    <x-button type="submit">Save</x-button>
                </form>
            </x-card>
        @endvolt
    </x-main>
</x-layouts.app>
