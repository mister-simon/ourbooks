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
        <x-app-menu-item
            title="Profile"
            icon="s-user-circle"
            :link="route('profile')" />

        <x-app-menu-item
            title="Logout"
            icon="s-lock-closed"
            x-on:click="$dispatch('logout')" />
    </x-menu>
@endauth
