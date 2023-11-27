<x-app-layout>
    <x-page-header>
        {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}

        <x-slot name="subtitle">
            <h3 class="sr-only">Users</h3>
            <ul class="flex flex-row gap-2">
                @foreach ($shelf->users as $user)
                    <li class="badge badge-neutral badge-sm h-auto">{{ $user->readable }}</li>
                @endforeach
                <li>
                    <a
                        href="{{ route('shelves.user.create', ['shelf' => $shelf]) }}"
                        class="btn btn-secondary btn-xs rounded-badge">+ Invite User</a>
                </li>
            </ul>
        </x-slot>

        <x-slot name="actions">
            <a
                href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}"
                class="btn btn-primary">Add Book</a>
        </x-slot>
    </x-page-header>

    <x-page-card class="card-compact">
        <table class="table table-zebra table-pin-rows">
            <thead>
                <tr class="z-10">
                    <th scope="col">Forename</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Series</th>
                    <th scope="col">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Edition</th>
                    <th scope="col">CoAuthor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    @if (($prevBook ?? null) && $book->author_surname_char !== $prevBook->author_surname_char)
                        {{-- This is kinda jank but it interjects the surname character, which sticks underneath the header row --}}
            </tbody>
            <thead>
                <tr class="top-6 z-20 bg-transparent">
                    <th class=""></th>
                    <th class="-translate-x-1 translate-y-2 py-0">
                        <span class="badge badge-lg w-full rounded-b-lg rounded-t-none border-none px-1">{{ $book->author_surname_char }}</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @endif

                {{-- Continue with book records --}}
                <tr>
                    <td>{{ $book->author_forename }}</td>
                    <td>{{ $book->author_surname }}</td>
                    <td>{{ $book->series_text }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->genre }}</td>
                    <td>{{ $book->edition }}</td>
                    <td>{{ $book->co_author }}</td>
                </tr>
                @php($prevBook = $book)
            @empty
                <tr>
                    <td colspan="100%" class="text-center">
                        No books yet -
                        <a href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}" class="link">Add A Book</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </x-page-card>

</x-app-layout>
