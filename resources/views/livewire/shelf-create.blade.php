<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? __('Create Shelf') }}
        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                @if ($shelf ?? false)
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
</div>
