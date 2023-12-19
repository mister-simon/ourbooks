<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? __('Create Shelf') }}

        <x-slot name="actions">
            @if ($shelf ?? null)
                <x-danger-button wire:click="confirmShelfDeletion" wire:loading.attr="disabled">
                    {{ __('Delete Shelf') }}
                </x-danger-button>
            @endif
        </x-slot>

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                @if ($shelf ?? null)
                    <li><a href="{{ route('shelves.show', ['shelf' => $shelf]) }}">{{ str($shelf->title)->limit(15) }}</a></li>
                @endif
                <li><a href="#" aria-current="page">{{ str($subtitle ?? __('New Shelf'))->limit(25) }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <x-page-card>
        <x-form-section submit="create">
            <x-slot name="title">
                {{ $subtitle ?? __('New Shelf') }}
            </x-slot>

            <x-slot name="description">
                <p>{{ __('What\'s this shelf for?') }}</p>
                <ul class="list-inside list-disc text-sm">
                    <li>{{ __('A personal shelf') }}</li>
                    <li>{{ __('A shared shelf with friends?') }}</li>
                    <li>{{ __('A family bookshelf?') }}</li>
                    <li>{{ __('Do you organise comics/graphic novels separately from your main collection?') }}</li>
                </ul>
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
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

    <x-dialog-modal wire:model.live="confirmingShelfDeletion">
        <x-slot name="title">
            {{ __('Delete Shelf') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this shelf? This is a permanent action that will delete all associated books their associated ratings, read statuses, and comments for all present users.') }}

            {{ $shelf->title }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingShelfDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteShelf" wire:loading.attr="disabled">
                {{ __('Delete Shelf') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
