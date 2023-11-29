<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? __('Shelf - :shelf', ['shelf' => $shelf->title]) . __(' - Create Book') }}
    </x-page-header>

    <x-page-card>
        <x-form-section submit="create" class="">
            <x-slot name="title">
                {{ $subtitle ?? __('New Book') }}
            </x-slot>

            <x-slot name="description">
                <div class="prose">
                    <p class="my-0">{{ __('Add a new book to your shelf.') }}</p>
                    <p class="my-0">{{ __('Similar books currently on your shelf:') }}</p>
                    <p><small>{{ $this->search }}</small></p>
                    <ul>
                        @forelse ($this->similarBooks as $book)
                            <li>
                                {{ $book->title }}
                                @if ($book->author_name)
                                    - {{ $book->author_name }}
                                @endif
                                @if ($book->series_text)
                                    - {{ $book->series_text }}
                                @endif
                            </li>
                        @empty
                            <li>{{ __('None found') }}</li>
                        @endforelse
                    </ul>
                </div>
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                    <x-label
                        for="forename"
                        value="{{ __('Author Forename') }}" />
                    <x-input
                        id="forename"
                        class="join-item mt-1 block w-full"
                        wire:model="state.forename" />
                    <x-input-error
                        for="forename"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                    <x-label
                        for="surname"
                        value="{{ __('Author Surname') }}" />
                    <x-input
                        id="surname"
                        class="join-item mt-1 block w-full"
                        wire:model="state.surname" />
                    <x-input-error
                        for="surname"
                        class="mt-2" />
                </div>

                <div class="col-span-6 md:col-span-3 lg:col-span-2">
                    <x-label
                        for="co_author"
                        value="{{ __('Co-Authors') }}" />
                    <x-input
                        id="co_author"
                        class="mt-1 block w-full"
                        wire:model="state.co_author" />
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
                        wire:model="state.title" />
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
                        wire:model="state.series" />
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

                <x-button>
                    {{ __('Save') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </x-page-card>
</div>
