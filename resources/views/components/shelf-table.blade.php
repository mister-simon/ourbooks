@props(['shelf'])

<div {{ $attributes->class('max-h-[80svh] overflow-x-auto') }}>
    <table
        class="table table-zebra table-sm [&_.middle]:py-0 [&_.middle]:text-center [&_.middle]:align-middle">
        <thead class="sticky top-0 z-10 bg-base-100">
            <tr>
                <th scope="col">
                    <div class="inline-grid grid-flow-col gap-2">
                        <label for="check_all" class="grid place-content-center">
                            <span class="sr-only">{{ __('Check all books') }}</span>
                            <input
                                type="checkbox"
                                name="check_all"
                                id="check_all"
                                class="checkbox checkbox-xs"
                                x-on:change="$dispatch('select-all', $el.checked)"
                                x-on:search-change.window="$el.checked = false" />
                        </label>
                    </div>
                </th>
                <th scope="col">{{ __('Forename') }}</th>
                <th scope="col">{{ __('Surname') }}</th>
                <th scope="col">{{ __('Series') }}</th>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Genre') }}</th>
                <th scope="col">{{ __('Edition') }}</th>
                <th scope="col">{{ __('Co-Author') }}</th>
                <th scope="col" class="middle">{{ __('Avg. Rating') }}</th>
                <th scope="col" class="middle">{{ __('Any Read') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
            </tr>
        </thead>

        @forelse ($this->filteredBooksByAuthor as $initial => $books)
            <thead class="border-y" wire:key="initial-{{ $initial }}">
                <tr class="border-b-0 bg-transparent">
                    <th scope="col" class="">
                        <label
                            for="check{{ $initial }}"
                            class="grid place-content-center">
                            <span class="sr-only">Check all '{{ $initial }}'</span>
                            <input
                                type="checkbox"
                                name="check{{ $initial }}"
                                id="check{{ $initial }}"
                                class="checkbox checkbox-xs"
                                x-on:change="$dispatch('select-letter', { char: '{{ $initial }}', checked: $el.checked })"
                                x-on:select-all.window="$el.checked = $event.detail"
                                x-on:search-change.window="$el.checked = false" />
                        </label>
                    </th>
                    <th class="sticky top-0 z-10 text-right">
                        <span class="badge aspect-square px-1 text-base-content/60">{{ $initial }}</span>
                    </th>
                </tr>
            </thead>

            <tbody wire:key="initial-{{ $initial }}-content">
                @foreach ($books as $book)
                    <tr wire:key="book-{{ $book->id }}" class="group hover" x-data>
                        <th scope="row">
                            <label
                                for="selected_{{ $book->id }}"
                                class="grid place-content-center">
                                <span class="sr-only">Select row</span>
                                <input
                                    type="checkbox"
                                    name="selected"
                                    id="selected_{{ $book->id }}"
                                    class="checkbox checkbox-xs"
                                    x-model="selected['{{ $book->id }}']"
                                    x-on:select-all.window="selected['{{ $book->id }}'] = $event.detail"
                                    x-on:select-letter.window="
                            $event.detail.char === '{{ $book->author_surname_char }}'
                                ? selected['{{ $book->id }}'] = $event.detail.checked
                                : null
                        " />
                            </label>
                        </th>
                        <td>{{ $book->author_forename }}</td>
                        <td>{{ $book->author_surname }}</td>
                        <td>{{ $book->series_text }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->edition }}</td>
                        <td>{{ $book->co_author }}</td>
                        <td class="middle">
                            <x-table-rating :rating="$book->book_user_avg_rating" />
                        </td>
                        <td class="middle">
                            <x-table-read :read="$book->was_read" />
                        </td>
                        <td>
                            <div class="inline-flex flex-row gap-2">
                                <a
                                    href="{{ route('shelves.book.show', ['shelf' => $shelf->id, 'book' => $book->id]) }}"
                                    class="btn btn-primary btn-xs">
                                    {{ __('View') }}
                                </a>
                                <a
                                    href="{{ route('shelves.book.edit', ['shelf' => $shelf->id, 'book' => $book->id]) }}"
                                    class="btn btn-secondary btn-xs">
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @empty
            <tr>
                <td colspan="100%" class="text-center">
                    {{ __('No books yet') }} -
                    <a href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}" class="link">{{ __('Add A Book') }}</a>
                </td>
            </tr>
        @endforelse
    </table>
</div>
