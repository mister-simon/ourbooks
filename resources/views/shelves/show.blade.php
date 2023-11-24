<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}
        </h2>
    </x-slot>

    <x-page-card>
        <table class="table table-zebra table-pin-rows table-sm">
            <thead>
                <tr>
                    <th scope="col">Forename</th>
                    <th scope="col" class="border-r">Surname</th>
                    <th scope="col">Series</th>
                    <th scope="col" class="border-r">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Edition</th>
                    <th scope="col">CoAuthor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->author_forename }}</td>
                        <td class="border-r">{{ $book->author_surname }}</td>
                        <td>{{ $book->series_text }}</td>
                        <td class="border-r">{{ $book->title }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->edition }}</td>
                        <td>{{ $book->co_author }}</td>
                @endforeach
            </tbody>
        </table>
    </x-page-card>

</x-app-layout>
