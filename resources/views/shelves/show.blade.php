<x-app-layout>
    <x-page-header>
        {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}

        <x-slot name="actions">
            <a href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}" class="btn btn-primary">Add Book</a>
        </x-slot>
    </x-page-header>

    <x-page-card class="card-compact">
        <table class="table table-zebra table-pin-rows">
            <thead>
                <tr class="[&>th]:after:absolute [&>th]:after:inset-x-0 [&>th]:after:-bottom-px [&>th]:after:block [&>th]:after:h-[1px] [&>th]:after:bg-neutral-700">
                    <th scope="col">Forename</th>
                    <th scope="col" class="border-r border-neutral-700">Surname</th>
                    <th scope="col">Series</th>
                    <th scope="col" class="border-r border-neutral-700">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Edition</th>
                    <th scope="col">CoAuthor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->author_forename }}</td>
                        <td class="border-r border-neutral-700">{{ $book->author_surname }}</td>
                        <td>{{ $book->series_text }}</td>
                        <td class="border-r border-neutral-700">{{ $book->title }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->edition }}</td>
                        <td>{{ $book->co_author }}</td>
                    </tr>
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
