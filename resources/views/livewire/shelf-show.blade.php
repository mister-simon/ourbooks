<div class="flex grow flex-col">
    <x-page-header>
        {{ $shelf->title }}

        <x-slot name="subtitle">
            <h3 class="sr-only">Users</h3>
            <ul class="flex flex-row gap-2">
                @foreach ($shelf->users as $user)
                    <x-avatar-badge :user="$user" />
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

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="#" aria-current="page">{{ str($shelf->title)->limit(15) }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <x-page-card class="card-compact relative w-full">
        <x-slot name="container" class="!block"></x-slot>

        <div class="indicator w-auto">
            <x-loading-indicator
                class="border-1 badge-success badge-outline indicator-center bg-base-100"
                wire:loading.delay
                wire:target="search" />

            <label class="form-control w-full">
                <div class="label sr-only">
                    <span class="label-text">Search</span>
                </div>
                <x-input
                    id="search"
                    type="search"
                    placeholder="Search"
                    class="input-primary"
                    wire:model.live.debounce="search"
                    x-on:change="$dispatch('search-change');" />
            </label>

            <x-button class="sr-only">Submit</x-button>
        </div>

        @if ($this->search)
            <div class="flex justify-between">
                <p class="px-4">
                    {{ trans_choice(':count result for search ":search".|:count results for search ":search".', $this->filteredBooksCount, ['search' => $this->search]) }}
                </p>
                <button
                    class="btn btn-outline btn-primary btn-sm"
                    wire:click="$set('search', '')">{{ __('Clear Search') }}</button>
            </div>
        @else
            <div class="flex justify-between">
                <p class="px-4">
                    {{ trans_choice(':count book on the shelf.|:count books on the shelf.', $this->filteredBooksCount) }}
                </p>
            </div>
        @endif

        <div
            class="max-h-[80svh] overflow-x-auto lg:max-h-none lg:overflow-x-visible"
            x-data="{
                shelfId: '{{ $shelf->id }}',
                selected: {},
                rating: 5,
                read: '{{ App\Enums\ReadStatus::YES->value }}',
                get onlySelected() {
                    return Object.entries(this.selected)
                        .filter(([, v]) => v)
                        .map(([k]) => k);
                }
            }">

            <div class="join join-horizontal" x-cloak>
                <div class="join-item flex flex-col items-center justify-start rounded-b-none rounded-t-box border p-4">
                    <p>Bulk Actions</p>
                    <p x-text="`{{ __('${onlySelected.length} currently selected') }}`"></p>
                </div>

                <div
                    class="join-item flex items-center justify-start gap-4 rounded-b-none rounded-t-box border p-4"
                    x-bind:disabled="onlySelected.length === 0">
                    <label class="form-control">
                        <div class="label sr-only">
                            <span class="label-text">{{ __('Rating') }}</span>
                        </div>
                        <select
                            name="rating"
                            id="rating"
                            class="select select-bordered select-sm"
                            x-model="rating">
                            @foreach (range(1, 10) as $rating)
                                <option value="{{ $rating }}">{{ $rating }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button
                        type="submit"
                        class="btn btn-sm"
                        @click.prevent="onlySelected.length && $wire.rateMany(onlySelected, shelfId, rating)">Save rating</button>
                </div>

                <div
                    class="join-item flex items-center justify-start gap-4 rounded-b-none rounded-t-box border p-4"
                    x-bind:disabled="onlySelected.length === 0">
                    <label class="label w-min cursor-pointer gap-4">
                        <span class="label-text sr-only">Read</span>

                        <select
                            name="read"
                            id="read"
                            class="select select-bordered select-sm"
                            x-model="read">
                            @foreach (App\Enums\ReadStatus::select() as $status => $trans)
                                <option value="{{ $status }}">{{ $trans }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button
                        type="submit"
                        class="btn btn-sm"
                        @click.prevent="onlySelected.length && $wire.readMany(onlySelected, shelfId, read)">Save read status</button>
                </div>
            </div>

            <table
                class="table table-pin-rows table-zebra table-sm [&_.middle]:py-0 [&_.middle]:text-center [&_.middle]:align-middle">
                <thead>
                    <tr class="z-10">
                        <th scope="col" class="relative">
                            <label for="check_all" class="absolute inset-0 grid place-content-center">
                                <span class="sr-only">Check all books</span>
                                <input
                                    type="checkbox"
                                    name="check_all"
                                    id="check_all"
                                    class="checkbox checkbox-xs"
                                    x-on:change="$dispatch('select-all', $el.checked)"
                                    x-on:search-change.window="$el.checked = false" />
                            </label>
                        </th>
                        <th scope="col">Forename</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Series</th>
                        <th scope="col">Title</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Edition</th>
                        <th scope="col">Co-Author</th>
                        <th scope="col" class="middle">Avg. Rating</th>
                        <th scope="col" class="middle">Any Read</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->filteredBooks as $book)
                        @if (($prevBook ?? null) === null || $book->author_surname_char !== $prevBook->author_surname_char)
                            {{-- This is kinda jank but it interjects the surname character, which sticks underneath the header row --}}
                </tbody>
                <thead class="border-y">
                    <tr class="-top-1 z-20 border-b-0 bg-transparent">
                        <th scope="col" class="relative">
                            <label for="check{{ $book->author_surname_char }}" class="absolute inset-0 grid place-content-center">
                                <span class="sr-only">Check all '{{ $book->author_surname_char }}'</span>
                                <input
                                    type="checkbox"
                                    name="check{{ $book->author_surname_char }}"
                                    id="check{{ $book->author_surname_char }}"
                                    class="checkbox checkbox-xs"
                                    x-on:change="$dispatch('select-letter', { char: '{{ $book->author_surname_char }}', checked: $el.checked })"
                                    x-on:select-all.window="$el.checked = $event.detail"
                                    x-on:search-change.window="$el.checked = false" />
                            </label>
                        </th>
                        <th class="-translate-x-1 text-right">
                            <span class="badge aspect-square px-1 text-base-content/60">{{ $book->author_surname_char }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @endif

                    {{-- Continue with book records --}}
                    <tr wire:key="{{ $book->id }}" class="group hover" x-data>
                        <th scope="row" class="relative">
                            <label for="selected_{{ $book->id }}" class="absolute inset-0 grid place-content-center">
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
                        <td class="middle [&_.badge]:aspect-square [&_.badge]:text-opacity-0 [&_.badge]:group-hover:text-opacity-75">
                            <span class="tooltip" data-tip="{{ $book->was_read->trans() }}">
                                @switch($book->was_read)
                                    @case(App\Enums\ReadStatus::YES)
                                        <span class="badge badge-success badge-lg aspect-square rounded-full border-base-content text-sm">
                                            {{ $book->was_read->transShort() }}
                                        </span>
                                    @break

                                    @case(App\Enums\ReadStatus::NO)
                                        <span class="badge badge-error badge-lg aspect-square rounded-full border-base-content text-sm">
                                            {{ $book->was_read->transShort() }}
                                        </span>
                                    @break

                                    @case(App\Enums\ReadStatus::PARTIAL)
                                        <span class="badge badge-warning badge-lg aspect-square rounded-full border-base-content text-sm">
                                            {{ $book->was_read->transShort() }}
                                        </span>
                                    @break

                                    @case(App\Enums\ReadStatus::UNKNOWN)
                                        <span class="badge badge-ghost badge-outline badge-lg aspect-square rounded-full text-sm">
                                            {{ $book->was_read->transShort() }}
                                        </span>
                                    @break
                                @endswitch
                            </span>
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
                    @php($prevBook = $book)
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">
                                {{ __('No books yet') }} -
                                <a href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}" class="link">{{ __('Add A Book') }}</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-page-card>
    </div>
