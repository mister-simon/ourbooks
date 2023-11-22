<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grow bg-gray-100 py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <ul class="menu">
                @foreach (auth()->user()->shelves as $shelf)
                    <li>
                        {{ $shelf->title }}
                        <ul class="menu">
                            @foreach ($shelf->books()->orderBy('author_surname')->orderBy('author_forename')->orderBy('series')->orderBy('series_index')->orderBy('title')->with('bookUsers.user')->get() as $book)
                                <li>
                                    {{ $book->title }}
                                    <ul class="menu">
                                        <li>{{ $book->author_forename }} - {{ $book->author_surname }}</li>
                                        @if ($book->co_author)
                                            <li>{{ $book->co_author }}</li>
                                        @endif
                                        <li>{{ $book->series_text }}</li>
                                        <li>{{ $book->title }}</li>
                                        <li>{{ $book->genre }}</li>
                                        <li>{{ $book->edition }}</li>
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
