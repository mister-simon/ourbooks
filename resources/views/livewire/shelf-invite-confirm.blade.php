<div class="flex grow flex-col">
    <x-page-header>
        {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}
        - {{ __('Confirm Invitation') }}

        <x-slot name="breadcrumbs">
            <ul>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('shelves.show', ['shelf' => $shelf]) }}">{{ str($shelf->title)->limit(15) }}</a></li>
                <li>{{ __('Invite User') }}</li>
            </ul>
        </x-slot>
    </x-page-header>

    <x-page-card>
        <x-form-section submit="submit" class="md:!grid-cols-1">
            <x-slot name="title">
                {{ __('Confirm Invitation') }}
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <p>{{ __(':name has invited to join ":shelf".', [
                        'name' => $invite->invitedBy->name,
                        'shelf' => $shelf->title,
                    ]) }}</p>
                    <p>{{ __('Press ":button" to accept the invitation and join.', [
                        'button' => __('Confirm'),
                    ]) }}</p>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Confirmed.') }}
                </x-action-message>

                <x-danger-button wire:click.prevent="submit('delete')">
                    {{ __('Delete') }}
                </x-danger-button>

                <x-button class="ms-3" wire:click.prevent="submit('confirm')">
                    {{ __('Confirm') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </x-page-card>
</div>
