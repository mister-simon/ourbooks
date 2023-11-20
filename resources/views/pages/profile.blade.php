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
    @volt('profile')
        <x-app-card class="w-full max-w-screen-md sm:w-auto">
            <x-subtitle>Profile</x-subtitle>

            @if ($this->user->google_id)
                <div class="prose">
                    <p>Your details are managed via your Google account.</p>
                    <p>
                        We only store a few things to identify you:
                    <ul>
                        <li>Google ID - Used to authenticate you uniquely with Google services.</li>
                        <li>Email - Only used as an alternative login method.</li>
                        <li>Nickname - Displayed on your shelves.</li>
                        <li>Avatar - Used as an icon for your profile. Otherwise unused / not shared.</li>
                    </ul>
                    </p>
                    <p>You may update your profile via your <a href="{{ url()->away('https://myaccount.google.com/') }}" target="_blank" rel="noopener noreferrer">Google account manager</a>.</p>
                </div>
            @else
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
            @endif
        </x-app-card>
    @endvolt
</x-layouts.app>
