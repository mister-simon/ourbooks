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
        <x-shelf-search />
        <x-shelf-bulk-actions />
        <x-shelf-table :shelf="$shelf" wire:key="{{ md5($this->search) }}" />
    </x-page-card-wide>
</div>
