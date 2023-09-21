<x-app-nav sticky class="relative z-20">
    <x-slot:brand>
        <a
            class="flex items-center gap-1"
            href="{{ route('home') }}">
            <img src="{{ asset('logo.svg') }}" alt="" class="h-10 w-10 invert dark:invert-0">
            {{ config('app.name') }}
        </a>
    </x-slot:brand>

    <x-slot:actions class="hidden flex-row !gap-0 sm:flex">
        @auth
            <label for="main-drawer" class="cursor-pointer p-4">
                <x-app-icon name="o-bars-3" class="shrink-0" />
            </label>
        @endauth
    </x-slot:actions>
</x-app-nav>
