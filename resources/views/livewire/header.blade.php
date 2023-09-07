<x-nav sticky>
    <x-slot:brand>
        @auth
            <!-- Drawer toggle for "main-drawer" -->
            <label for="main-drawer" class="mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        @endauth

        <a
            class="flex items-center gap-1"
            href="{{ route('home') }}">
            @svg('heroicon-s-book-open', 'w-5 h-5') {{ config('app.name') }}
        </a>
    </x-slot:brand>

    <x-slot:actions class="hidden sm:block">
        @auth
            @if ($user->name)
                <span>Hi, {{ $user->name }}!</span>
            @endif

            <a href="{{ route('profile') }}"><x-icon name="s-user-circle" /> Profile</a>
            <a href="" wire:click.prevent="logout"><x-icon name="s-lock-closed" /> Logout</a>
        @endauth
    </x-slot:actions>
</x-nav>
