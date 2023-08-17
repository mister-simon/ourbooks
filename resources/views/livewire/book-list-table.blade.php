<?php

use function Livewire\Volt\{state, computed};

state(['books' => fn() => $books]);

?>

<table class="w-full table-auto text-left text-sm">
    <thead class="border-b font-medium dark:border-neutral-500">
        <tr>
            <td scope="col" class="p-2">Surname</td>
            <td scope="col" class="p-2">Forename</td>
            <td scope="col" class="p-2">Series</td>
            <td scope="col" class="p-2">Title</td>
            <td scope="col" class="p-2">Genre</td>
            <td scope="col" class="p-2">Edition</td>
            <td scope="col" class="p-2">Co Author</td>
        </tr>
    </thead>
    <tbody>
        @forelse ($this->books as $book)
            @if ($next = $this->books[$loop->index + 1] ?? null)
            @endif
            <tr class="@if ($next && $next->authorName !== $book->authorName) border-neutral-500 @endif border-b transition duration-300 ease-in-out hover:bg-neutral-300">
                <td class="p-2">{{ $book->author_surname }}</td>
                <td class="border-r p-2 dark:border-neutral-500">{{ $book->author_forename }}</td>
                <td class="p-2">{{ $book->series_text }}</td>
                <td class="border-r p-2 dark:border-neutral-500">{{ $book->title }}</td>
                <td class="p-2">{{ $book->genre }}</td>
                <td class="p-2">{{ $book->edition }}</td>
                <td class="p-2">{{ $book->co_author }}</td>
            </tr>
        @empty
            <tr>
                <td width="100%">No books yet...</td>
            </tr>
        @endforelse
    </tbody>
</table>
