<div class="flex grow flex-col">
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
                href="{{ route('shelves.edit', ['shelf' => $shelf]) }}"
                class="btn btn-primary ml-auto">Edit Shelf</a>
            <a
                href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}"
                class="btn btn-primary">Add Book</a>
        </x-slot>
    </x-page-header>

    <x-page-card class="card-compact relative">
        <div class="indicator w-auto">
            <x-loading-indicator
                class="border-1 badge-success badge-outline indicator-center bg-base-100"
                wire:loading.delay
                wire:target="state.search" />

            <label class="form-control w-full">
                <div class="label sr-only">
                    <span class="label-text">Search</span>
                </div>
                <x-input
                    id="search"
                    type="search"
                    placeholder="Search"
                    class="input-primary"
                    wire:model.live.debounce="state.search" />
            </label>

            <x-button class="sr-only">Submit</x-button>
        </div>

        @if ($this->state['search'])
            <div class="flex justify-between">
                <p class="px-4">
                    {{ trans_choice(':count result for search ":search".|:count results for search ":search".', $this->filteredBooksCount, ['search' => $this->state['search']]) }}
                </p>
                <button
                    class="btn btn-outline btn-primary btn-sm"
                    wire:click="$set('state.search', '')">{{ __('Clear Search') }}</button>
            </div>
        @else
            <div class="flex justify-between">
                <p class="px-4">
                    {{ trans_choice(':count book on the shelf.|:count books on the shelf.', $this->filteredBooksCount) }}
                </p>
            </div>
        @endif

        <table class="table table-pin-rows table-zebra">
            <thead>
                <tr class="z-10">
                    <th scope="col">Forename</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Series</th>
                    <th scope="col">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Edition</th>
                    <th scope="col">CoAuthor</th>
                    <th scope="col" class="sr-only">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->filteredBooks as $book)
                    @if (($prevBook ?? null) === null || $book->author_surname_char !== $prevBook->author_surname_char)
                        {{-- This is kinda jank but it interjects the surname character, which sticks underneath the header row --}}
            </tbody>
            <thead class="border-y">
                <tr class="pointer-events-none -top-1 z-20 border-b-0 bg-transparent">
                    <th></th>
                    <th class="-translate-x-1 text-right">
                        <span class="badge aspect-square px-1 text-base-content/60">{{ $book->author_surname_char }}</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @endif

                {{-- Continue with book records --}}
                <tr wire:key="{{ $book->id }}" class="hover cursor-pointer" @click="$refs.edit.click()" x-data>
                    <td>{{ $book->author_forename }}</td>
                    <td>{{ $book->author_surname }}</td>
                    <td>{{ $book->series_text }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->genre }}</td>
                    <td>{{ $book->edition }}</td>
                    <td>{{ $book->co_author }}</td>
                    <td class="sr-only">
                        <a href="{{ route('shelves.book.edit', ['shelf' => $shelf->id, 'book' => $book->id]) }}" x-ref="edit">Edit</a>
                    </td>
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
</div>
