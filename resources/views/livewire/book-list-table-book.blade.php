<tr
    class="{{ $this->rowClasses }} whitespace-nowrap border-b px-6 py-2 transition duration-300 ease-in-out hover:bg-neutral-100 dark:hover:bg-neutral-600">
    <td class="whitespace-break-spaces px-6 py-2">{{ $this->book->author_surname }}</td>
    <td class="whitespace-break-spaces border-r px-6 py-2 dark:border-neutral-500">{{ $this->book->author_forename }}</td>
    <td class="whitespace-break-spaces px-6 py-2">{{ $this->book->series_text }}</td>
    <td class="whitespace-break-spaces border-r px-6 py-2 dark:border-neutral-500">{{ $this->book->title }}</td>
    <td class="whitespace-break-spaces px-6 py-2">{{ $this->book->genre }}</td>
    <td class="whitespace-break-spaces px-6 py-2">{{ $this->book->edition }}</td>
    <td class="whitespace-break-spaces px-6 py-2">{{ $this->book->co_author }}</td>
</tr>
