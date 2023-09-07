@unless ($noHome ?? false)
    <x-menu>
        <x-menu-item
            :title="config('app.name')"
            icon="s-book-open"
            :link="route('home')" />
    </x-menu>
@endunless
@auth
    <x-menu title="User">
        <x-menu-item
            title="Profile"
            icon="s-user-circle"
            :link="route('profile')" />

        <x-menu-item
            title="Logout"
            icon="s-lock-closed"
            x-on:click="$dispatch('logout')" />
    </x-menu>

    <livewire:sidebar-shelf-list />
@endauth
