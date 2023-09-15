@unless ($noHome ?? false)
    <x-menu title="Home">
        <x-app-menu-item
            :title="config('app.name')"
            icon="s-book-open"
            :link="route('home')" />
    </x-menu>
@endunless
@auth
    <livewire:sidebar-shelf-list />

    <x-menu title="User">
        @if (auth()->user()->avatar)
            <x-app-menu-item :link="route('profile')">
                <div class="flex flex-row items-center justify-between">
                    <img src="{{ auth()->user()->avatar }}" alt="User Avatar" class="mr-2 h-5 w-5 rounded-full object-cover">
                    Profile
                </div>
            </x-app-menu-item>
        @else
            <x-app-menu-item
                title="Profile"
                icon="s-user-circle"
                :link="route('profile')" />
        @endif

        <x-app-menu-item
            title="Logout"
            icon="s-lock-closed"
            x-on:click="$dispatch('logout')" />
    </x-menu>
@endauth
