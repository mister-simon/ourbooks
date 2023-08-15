<?php

use function Livewire\Volt\{state, on};
use Illuminate\Support\Facades\Auth;

state(['user' => fn() => Auth::user()]);

on(['profile-update' => fn() => ($this->user = Auth::user())]);

$logout = function () {
    Auth::logout();

    $this->redirect('/', navigate: true);
};

?>

<header>
    <nav class="flex items-center justify-between p-4">
        <a href="/">{{ config('app.name') }}</a>

        @auth
            <div class="flex items-center justify-between gap-4">
                @if ($user->name)
                    <span>Hi, {{ $user->name }}!</span>
                @endif

                <x-link href="{{ route('profile') }}">Profile</x-link>
                <form wire:submit="logout">
                    <x-button type="submit">Logout</x-button>
                </form>
            </div>
        @endauth
    </nav>
</header>
