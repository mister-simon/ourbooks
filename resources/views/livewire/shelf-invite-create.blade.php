<div class="flex grow flex-col">
    <x-page-header>
        {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}
        {{ __(' - Invite User') }}
    </x-page-header>

    <x-page-card>

        <x-form-section submit="create">
            <x-slot name="title">
                {{ __('Invite a Friend') }}
            </x-slot>

            <x-slot name="description">
                If your friend already has an account they will receive a notification that you want them to join your Shelf.
                If not, we will send an email inviting them to join.
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-label
                        for="email"
                        value="{{ __('Email') }}" />
                    <x-input
                        id="email"
                        class="mt-1 block w-full"
                        wire:model="state.email" />
                    <x-input-error
                        for="email"
                        class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Invite Sent.') }}
                </x-action-message>

                <x-button>
                    {{ __('Send Invite') }}
                </x-button>
            </x-slot>
        </x-form-section>

        <div class="mt-4">
            <h2 class="mb-2">Invited:</h2>
            <ul class="flex flex-row gap-2">
                @foreach ($shelf->invites as $invite)
                    <li class="badge">{{ $invite->email ?? $invite->user->email }}</li>
                @endforeach
            </ul>
        </div>
    </x-page-card>
</div>
