<?php

use function Livewire\Volt\{state};
use Illuminate\Support\Facades\Auth;

$logout = function () {
    Auth::logout();
    $this->redirect('/', navigate: true);
};

?>

<header>
    <nav class="flex items-center justify-between p-4">
        <a href="/">{{ config('app.name') }}</a>

        @auth
            <form wire:submit="logout">
                <x-button type="submit">Logout</x-button>
            </form>
        @endauth
    </nav>
</header>
