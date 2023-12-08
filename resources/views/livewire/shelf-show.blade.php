<div class="flex grow flex-col">
    <x-page-header>
        {{ $shelf->title }}

        <x-slot name="subtitle">
            <h3 class="sr-only">{{ __('Users') }}</h3>
            <ul class="flex flex-row gap-2">
                @foreach ($shelf->users as $user)
                    <x-avatar-badge :user="$user" />
                @endforeach
                <li>
                    <a
                        href="{{ route('shelves.user.create', ['shelf' => $shelf]) }}"
                        class="btn btn-secondary btn-xs rounded-badge">+ {{ __('Invite User') }}</a>
                </li>
            </ul>
        </x-slot>

        <x-slot name="actions">
            <a
                href="{{ route('shelves.edit', ['shelf' => $shelf]) }}"
                class="btn btn-primary ml-auto">{{ __('Edit Shelf') }}</a>
            <a
                href="{{ route('shelves.book.create', ['shelf' => $shelf]) }}"
                class="btn btn-primary">{{ __('Add Book') }}</a>
        </x-slot>

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="#" aria-current="page">{{ str($shelf->title)->limit(15) }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <x-page-card-wide
        class="card-compact relative w-full"
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
        <x-slot name="container" class="!block"></x-slot>

        <div class="indicator w-auto">
            <x-loading-indicator
                class="border-1 badge-success badge-outline indicator-center bg-base-100"
                wire:loading.delay
                wire:target="search" />

            <label class="form-control w-full">
                <div class="label sr-only">
                    <span class="label-text">{{ __('Search') }}</span>
                </div>
                <x-input
                    id="search"
                    type="search"
                    placeholder="Search"
                    class="input-primary"
                    wire:model.live.debounce="search"
                    x-on:change="$dispatch('search-change');" />
            </label>

            <x-button class="sr-only">{{ __('Submit') }}</x-button>
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

        <div class="flex flex-row gap-4">
            <div
                class="dropdown dropdown-bottom"
                x-data="{ isOpen: false }"
                x-cloak>
                <div
                    tabindex="0"
                    role="button"
                    class="btn btn-outline btn-xs">
                    <span x-text="`{{ __('${onlySelected.length} currently selected') }} ▼`"></span>
                </div>

                <div
                    class="dropdown-content z-20"
                    tabindex="0">
                    <div class="join join-vertical w-max bg-base-100 md:join-horizontal" x-cloak>
                        <div
                            class="join-item flex items-start justify-start gap-4 rounded-b-none rounded-t-box border p-4">
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

                                @error('rating')
                                    <div class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>

                            <button
                                type="submit"
                                class="btn btn-sm"
                                x-bind:disabled="onlySelected.length === 0"
                                @click.prevent="onlySelected.length && $wire.rateMany(onlySelected, shelfId, rating)">{{ __('Rate') }}</button>
                        </div>

                        <div
                            class="join-item flex items-start justify-start gap-4 rounded-b-none rounded-t-box border p-4">
                            <label class="form-control">
                                <div class="label sr-only">
                                    <span class="label-text">{{ __('Read') }}</span>
                                </div>

                                <select
                                    name="read"
                                    id="read"
                                    class="select select-bordered select-sm"
                                    x-model="read">
                                    @foreach (App\Enums\ReadStatus::select() as $status => $trans)
                                        <option value="{{ $status }}">{{ $trans }}</option>
                                    @endforeach
                                </select>

                                @error('read')
                                    <div class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <button
                                type="submit"
                                class="btn btn-sm"
                                x-bind:disabled="onlySelected.length === 0"
                                @click.prevent="onlySelected.length && $wire.readMany(onlySelected, shelfId, read)">{{ __('Set Read') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <x-action-message on="saved">{{ __('Saved.') }}</x-action-message>
        </div>

        <div class="max-h-[80svh] overflow-x-auto">
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
    </x-page-card-wide>
</div>
