<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Shelves') }}
        </h2>
        <a href="{{ route('shelves.create') }}" class="btn btn-primary">New Shelf</a>
    </x-slot>

    <div class="grow bg-gray-100 py-12">
        <div class="mx-auto grid max-w-7xl sm:grid-cols-2 sm:px-6 lg:grid-cols-3 lg:px-8">
            @foreach ($shelves as $shelf)
                <div class="card bg-base-100 shadow-xl transition-transform focus-within:scale-110 hover:scale-110">
                    <div class="card-body">
                        <h2 class="card-title grow">{{ $shelf->title }}</h2>
                        <div class="flex flex-row gap-2">
                            @foreach ($shelf->users as $user)
                                <li class="badge badge-neutral">{{ $user->readable }}</li>
                            @endforeach
                        </div>
                        <ul>
                            <li class="italic">{{ trans_choice(':count book|:count books', $shelf->books_count) }}</li>
                            <li>{{ trans_choice(':count author|:count authors', $authorCounts[$shelf->id]) }}</li>
                        </ul>
                        <a href="{{ route('shelves.show', $shelf->id) }}" class="absolute inset-0">
                            <span class="sr-only">{{ __('View shelf') }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
