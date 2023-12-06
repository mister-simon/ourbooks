<x-app-layout>
    <x-page-header>
        {{ __('Shelves') }}

        <x-slot name="actions">
            <a
                href="{{ route('shelves.create') }}"
                class="btn btn-primary"
                wire:navigate>New Shelf</a>
        </x-slot>

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="#" aria-current="page">{{ __('Home') }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <div class="grow bg-gray-100 py-12">
        <div class="container mx-auto grid gap-4 sm:grid-cols-2 sm:px-6 lg:grid-cols-3 lg:px-8">

            @foreach ($invites as $invite)
                @php($shelf = $invite->shelf)
                <div class="card indicator z-0 w-auto bg-base-100 shadow-xl transition-transform focus-within:z-10 focus-within:scale-110 hover:z-10 hover:scale-110">
                    <div class="card-body">
                        <div class="indicator-center badge indicator-item badge-secondary">New Invite</div>
                        <h2 class="card-title grow">{{ $shelf->title }}</h2>
                        <div class="flex flex-row flex-wrap gap-2">
                            @foreach ($shelf->users as $user)
                                <x-avatar-badge :user="$user" />
                            @endforeach
                        </div>
                        <ul>
                            <li class="italic">{{ trans_choice(':count book|:count books', $shelf->books_count) }}</li>
                            <li>{{ trans_choice(':count author|:count authors', $authorCounts[$shelf->id] ?? 0) }}</li>
                        </ul>
                        <a
                            href="{{ route('shelves.show', $shelf->id) }}"
                            class="absolute inset-0 focus-visible:outline-none">
                            <span class="sr-only">{{ __('View shelf') }}</span>
                        </a>
                    </div>
                </div>
            @endforeach

            @foreach ($shelves as $shelf)
                <div class="card z-0 bg-base-100 shadow-xl transition-transform focus-within:z-10 focus-within:scale-110 hover:z-10 hover:scale-110">
                    <div class="card-body">
                        <h2 class="card-title grow">{{ $shelf->title }}</h2>
                        <div class="flex flex-row flex-wrap gap-2">
                            @foreach ($shelf->users as $user)
                                <x-avatar-badge :user="$user" />
                            @endforeach
                        </div>
                        <ul>
                            <li class="italic">{{ trans_choice(':count book|:count books', $shelf->books_count) }}</li>
                            <li>{{ trans_choice(':count author|:count authors', $authorCounts[$shelf->id] ?? 0) }}</li>
                        </ul>
                        <a
                            href="{{ route('shelves.show', $shelf->id) }}"
                            class="absolute inset-0 focus-visible:outline-none">
                            <span class="sr-only">{{ __('View shelf') }}</span>
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="card z-0 bg-primary text-primary-content shadow-xl transition-transform focus-within:scale-110 hover:z-10 hover:scale-110">
                <div class="card-body">
                    <h2 class="card-title not-sr-only grow">{{ __('Create a New Shelf') }}</h2>
                    <div class="flex flex-row gap-2">
                        <x-avatar-badge :user="Auth::user()" />
                    </div>
                    <ul>
                        <li class="italic">{{ trans_choice(':count book|:count books', 0) }}</li>
                        <li>{{ trans_choice(':count author|:count authors', 0) }}</li>
                    </ul>
                    <a
                        href="{{ route('shelves.create') }}"
                        class="absolute inset-0 focus-visible:outline-none"
                        wire:navigate>
                        <span class="sr-only">{{ __('Create A New Shelf') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
