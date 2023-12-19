<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? $shelf->title . ' - ' . __('Create Book') }}

        <x-slot name="actions">
            @if ($book ?? null)
                <x-danger-button wire:click="confirmBookDeletion" wire:loading.attr="disabled">
                    {{ __('Delete Book') }}
                </x-danger-button>
            @endif
        </x-slot>

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('shelves.show', ['shelf' => $shelf]) }}">{{ str($shelf->title)->limit(15) }}</a></li>
                @if ($book ?? null)
                    <li><a href="{{ route('shelves.book.show', ['shelf' => $shelf, 'book' => $book]) }}">{{ str($book->title)->limit(15) }}</a></li>
                @endif
                <li><a href="#" aria-current="page">{{ str($subtitle ?? __('New Book'))->limit(25) }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <x-page-card>
        <x-form-section submit="create">
            <x-slot name="title">
                {{ $subtitle ?? __('New Book') }}
            </x-slot>

            <x-slot name="description">
                @if ($book ?? null)
                @else
                    <p>{{ __('Add a new book to your shelf.') }}</p>
                @endif
                @if ($this->search)
                    <p>{{ __('Similar books currently on your shelf:') }}</p>
                    <p><small>{{ __('Searching for ":search"', ['search' => $this->search]) }}</small></p>
                    <ul class="mt-4 list-disc ps-6">
                        @forelse ($this->similarBooks as $similarBook)
                            <li wire:key="{{ $similarBook->id }}">
                                <div class="flex flex-row items-start gap-1">
                                    <button
                                        class="link"
                                        wire:click="fillBook('{{ $similarBook->id }}')">Use</button> -
                                    <div class="grow">
                                        @if ($similarBook->series_text)
                                            {{ $similarBook->series_text }} -
                                        @endif
                                        {{ $similarBook->title }}
                                        @if ($similarBook->author_name)
                                            - {{ $similarBook->author_name }}
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>{{ __('None found') }}</li>
                        @endforelse
                    </ul>
                @endif
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                    <x-label
                        for="author_forename"
                        value="{{ __('Author Forename') }}" />
                    <x-input
                        id="author_forename"
                        class="mt-1 block w-full"
                        wire:model.live.debounce="state.author_forename"
                        x-data
                        x-on:saved.window="$el.focus()" />
                    <x-input-error
                        for="author_forename"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                    <x-label
                        for="author_surname"
                        value="{{ __('Author Surname') }}" />
                    <x-input
                        id="author_surname"
                        class="mt-1 block w-full"
                        wire:model.live.debounce="state.author_surname" />
                    <x-input-error
                        for="author_surname"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                    <x-label
                        for="co_author"
                        value="{{ __('Co-Authors') }}" />
                    <x-input
                        id="co_author"
                        class="mt-1 block w-full"
                        wire:model.live.debounce="state.co_author" />
                    <x-input-error
                        for="co_author"
                        class="mt-2" />
                </div>

                <div class="col-span-6">
                    <x-label
                        for="title"
                        value="{{ __('Title') }}" />
                    <x-input
                        id="title"
                        class="mt-1 block w-full"
                        required
                        wire:model.live.debounce="state.title" />
                    <x-input-error
                        for="title"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3">
                    <x-label
                        for="series"
                        value="{{ __('Series') }}" />
                    <x-input
                        id="series"
                        name="genre"
                        class="mt-1 block w-full"
                        wire:model.live.debounce="state.series" />
                    <x-input-error
                        for="series"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3">
                    <x-label
                        for="series_index"
                        value="{{ __('Series Index') }}" />
                    <x-input
                        name="series_index"
                        id="series_index"
                        type="number"
                        class="mt-1 block w-full"
                        min="0"
                        wire:model="state.series_index" />
                    <x-input-error
                        for="series_index"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3">
                    <x-label
                        for="genre"
                        value="{{ __('Genre') }}" />
                    <x-input-genre
                        name="genre"
                        class="mt-1 block w-full"
                        placeholder=""
                        wire:model="state.genre" />
                    <x-input-error
                        for="genre"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3">
                    <x-label
                        for="edition"
                        value="{{ __('Edition') }}" />
                    <x-input
                        name="edition"
                        id="edition"
                        class="mt-1 block w-full"
                        wire:model="state.edition" />
                    <x-input-error
                        for="edition"
                        class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Saved.') }}
                </x-action-message>

                <button wire:click="resetState" class="btn btn-outline" type="button">
                    {{ __('Reset') }}
                </button>

                <x-button class="ms-3">
                    {{ __('Save') }}
                </x-button>

                @unless ($book ?? null)
                    <x-button class="ms-3" wire:click="create(true)" type="button">
                        {{ __('Save and Add Another') }}
                    </x-button>
                @endunless
            </x-slot>
        </x-form-section>
    </x-page-card>

    <x-dialog-modal wire:model.live="confirmingBookDeletion">
        <x-slot name="title">
            {{ __('Delete Book') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this book? This is a permanent action that will delete all users\' associated ratings, read statuses, and comments.') }}

            {{ $book->title }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingBookDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteBook" wire:loading.attr="disabled">
                {{ __('Delete Book') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
