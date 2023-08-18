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

<header class="sticky top-0 z-30">
    <!-- Main navigation container -->
    <nav
        class="flex-no-wrap relative flex w-full items-center justify-between bg-[#FBFBFB] py-2 shadow-md shadow-black/5 dark:bg-neutral-600 dark:shadow-black/10 lg:flex-wrap lg:justify-start lg:py-4"
        data-te-navbar-ref>
        <div class="flex w-full flex-wrap items-center justify-between px-3">
            <a
                class="text-neutral-500 dark:text-neutral-200 lg:px-2"
                href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>

            <!-- Hamburger button for mobile view -->
            <button
                class="block border-0 bg-transparent px-2 text-neutral-500 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 lg:hidden"
                type="button"
                data-te-collapse-init
                data-te-target="#mainNavBar"
                aria-controls="mainNavBar"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <!-- Hamburger icon -->
                <span class="[&>svg]:w-7">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-7 w-7">
                        <path
                            fill-rule="evenodd"
                            d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            </button>

            <!-- Collapsible navigation container -->
            <div
                class="!visible hidden flex-grow basis-[100%] items-center lg:!flex lg:basis-auto"
                id="mainNavBar"
                data-te-collapse-item>
                @auth
                    <ul
                        class="list-style-none ml-auto flex flex-col pl-0 lg:flex-row"
                        data-te-navbar-nav-ref>

                        @if ($user->name)
                            <x-navbar-text>
                                Hi, {{ $user->name }}!
                            </x-navbar-text>
                        @endif

                        <x-navbar-link
                            :href="route('profile')"
                            class="inline-flex items-center justify-between gap-2">
                            @svg('heroicon-o-user-circle', 'w-4 h-4') Profile
                        </x-navbar-link>

                        <x-navbar-link href="" wire:click="logout">
                            Logout
                        </x-navbar-link>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

</header>
