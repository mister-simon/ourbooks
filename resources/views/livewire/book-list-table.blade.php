<div>
    @if ($this->search)
        <div class="flex justify-between">
            <p>{{ $this->books->count() }} results for search "{{ $this->search }}".</p>
            <x-button wire:click="$dispatch('book-search-set', { search: null })">Clear Search</x-button>
        </div>
    @else
        <div class="flex justify-between">
            <p>{{ $this->books->count() }} books displayed.</p>
        </div>
    @endif

    <div class="max-w-full overflow-auto">
        <table class="w-full table-auto overflow-auto text-left text-sm font-light">
            <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <td scope="col" class="px-6 py-2">Surname</td>
                    <td scope="col" class="border-r px-6 py-2">Forename</td>
                    <td scope="col" class="px-6 py-2">Series</td>
                    <td scope="col" class="border-r px-6 py-2">Title</td>
                    <td scope="col" class="px-6 py-2">Genre</td>
                    <td scope="col" class="px-6 py-2">Edition</td>
                    <td scope="col" class="px-6 py-2">Co Author</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->groupedBooks as $char => $group)
                    <tr key="{{ 'authorChar-' . $char }}">
                        <td colspan="100%" class="whitespace-nowrap border-y bg-neutral-100 px-6 text-center transition duration-300 ease-in-out dark:bg-neutral-600">{{ $char }}</td>
                    </tr>
                    @foreach ($group as $book)
                        <tr
                            class="@if (($next = $this->books[$loop->index + 1] ?? null) && $next->authorName !== $book->authorName) border-neutral-500 dark:border-neutral-200 @else border-neutral-200 dark:border-neutral-500 @endif whitespace-nowrap border-b px-6 py-2 transition duration-300 ease-in-out hover:bg-neutral-100 dark:hover:bg-neutral-600"
                            key="{{ 'tableBook-' . $book->id }}">
                            <td class="whitespace-break-spaces px-6 py-2">{{ $book->author_surname }}</td>
                            <td class="whitespace-break-spaces border-r px-6 py-2 dark:border-neutral-500">{{ $book->author_forename }}</td>
                            <td class="whitespace-break-spaces px-6 py-2">{{ $book->series_text }}</td>
                            <td class="whitespace-break-spaces border-r px-6 py-2 dark:border-neutral-500">{{ $book->title }}</td>
                            <td class="whitespace-break-spaces px-6 py-2">{{ $book->genre }}</td>
                            <td class="whitespace-break-spaces px-6 py-2">{{ $book->edition }}</td>
                            <td class="whitespace-break-spaces px-6 py-2">{{ $book->co_author }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td width="100%">No books here...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
