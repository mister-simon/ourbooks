<div class="flex grow flex-col">
    <x-page-header>
        {{ __('Shelf - :shelf', ['shelf' => $shelf->title]) }}
        - {{ __('Invite User') }}

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('shelves.show', ['shelf' => $shelf]) }}">{{ str($shelf->title)->limit(15) }}</a></li>
                <li><a href="#" aria-current="page">{{ __('Invite User') }}</a></li>
            </ol>
        </x-slot>
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
                        for="name"
                        value="{{ __('Name') }}" />
                    <x-input
                        id="name"
                        class="mt-1 block w-full"
                        wire:model="state.name" />
                    <x-input-error
                        for="name"
                        class="mt-2" />
                </div>

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

            <div class="mt-4">
                <h2 class="mb-2 block text-sm font-medium text-gray-700">Invited:</h2>
                <ul class="flex flex-row flex-wrap gap-2">
                    @forelse ($shelf->invites as $invite)
                        <li class="badge badge-lg pe-0">
                            {{ $invite->email ?? $invite->user->email }}
                            <button
                                class="btn btn-error btn-xs relative ms-2 aspect-square h-full min-h-min scale-105 rounded-badge"
                                type="button"
                                wire:click="confirmInviteDeletion('{{ $invite->id }}')"
                                wire:loading.attr="disabled">
                                x
                            </button>
                        </li>
                    @empty
                        <li class="badge badge-outline">No invites sent.</li>
                    @endforelse
                </ul>

                <x-dialog-modal wire:model.live="confirmingInviteDeletion">
                    <x-slot name="title">
                        {{ __('Delete Invite') }}
                    </x-slot>

                    <x-slot name="content">
                        @if ($confirmingInvite ?? false)
                            <div class="badge mb-4">
                                {{ $confirmingInvite->email ?? $confirmingInvite->user->email }}
                            </div>
                        @endif

                        <div>
                            <p>{{ __('Are you sure you want to delete this invite?') }}</p>
                            <p>{{ __('The user\'s link to confirm the invitation will no longer work.') }}</p>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-secondary-button
                            wire:click="$toggle('confirmingInviteDeletion')"
                            wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button
                            class="ms-3"
                            wire:click="deleteInvite"
                            wire:loading.attr="disabled">
                            {{ __('Delete Invite') }}
                        </x-danger-button>
                    </x-slot>
                </x-dialog-modal>

            </div>

            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Invite Sent.') }}
                </x-action-message>

                <x-button>
                    {{ __('Send Invite') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </x-page-card>
</div>
