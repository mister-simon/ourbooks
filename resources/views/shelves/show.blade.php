<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}
        </h2>
    </x-slot>

    <div class="grow bg-gray-100 py-12">
        <div class="mx-auto grid max-w-7xl sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
