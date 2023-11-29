<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? __('Shelf - :shelf', ['shelf' => $shelf->title]) . __(' - Create Book') }}
    </x-page-header>

    <x-page-card>
        <x-form-section submit="create">
            <x-slot name="title">
                {{ $subtitle ?? __('New Book') }}
            </x-slot>

            <x-slot name="description">
                <p>{{ __('Add a new book to your shelf.') }}</p>
                @if ($this->search)
                    <p>{{ __('Similar books currently on your shelf:') }}</p>
                    <p><small>"{{ $this->search }}"</small></p>
                    <ul class="mt-4 list-disc ps-6">
                        @forelse ($this->similarBooks as $book)
                            <li wire:key="{{ $book->id }}">
                                <div class="flex flex-row items-start gap-1">
                                    <button
                                        class="link"
                                        wire:click="fillBook('{{ $book->id }}')">Use</button> -
                                    <div class="grow">
                                        @if ($book->series_text)
                                            {{ $book->series_text }} -
                                        @endif
                                        {{ $book->title }}
                                        @if ($book->author_name)
                                            - {{ $book->author_name }}
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
                        class="join-item mt-1 block w-full"
                        wire:model.live.debounce="state.author_forename" />
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
                        class="join-item mt-1 block w-full"
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
                        name="series"
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
            </x-slot>
        </x-form-section>
    </x-page-card>
</div>
