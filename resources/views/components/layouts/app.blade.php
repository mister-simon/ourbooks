<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }} | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
        rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col antialiased" x-data="{ headerStuck: false }">
    <noscript class="fixed z-50 flex h-full w-full flex-col items-center justify-center bg-inherit">
        <div class="max-w-prose space-y-5 text-center">
            <h1 class="pb-9 text-4xl font-extrabold leading-5">Hey, there no-js person.</h1>
            <p>I'm really sorry, this website fully doesn't work without Javascript.</p>
            <p>One day I might remedy that... Right now this is just a personal project, so for now you're out of luck.</p>
        </div>
    </noscript>

    @persist('header')
        <livewire:header />
    @endpersist

    <x-app-main class="grow" :hide-sidebar="$hideSidebar ?? false">
        <x-slot:sidebar drawer="main-drawer">
            @persist('sidebar')
                <x-app-card title="" class="main-sidebar gutter-stable custom-scrollbar mb-auto hidden w-full max-w-[280px] flex-col overflow-auto rounded-t-none lg:flex">
                    <x-layouts.sidebar no-home />
                </x-app-card>
            @endpersist
        </x-slot:sidebar>

        <x-slot:sidebar-drawer class="sm:min-w-[20vw]">
            @persist('sidebar-drawer')
                <x-layouts.sidebar />
            @endpersist
        </x-slot:sidebar>

        <!-- The `$slot` goes here -->
        <x-slot:content class="flex flex-col items-center justify-center">
            {{ $slot }}
        </x-slot:content>

        <!-- Footer area -->
        <x-slot:footer>
            @persist('footer')
                <x-footer />
            @endpersist
        </x-slot:footer>
    </x-app-main>

    @persist('bg-canvas')
        <x-bg-canvas />
    @endpersist

</body>

</html>
