<div>
    <x-subtitle>
        New Book
    </x-subtitle>

    <form wire:submit="create">
        <div class="grid grid-cols-4 gap-2">
            <x-text-input name="title" wire:model.live.debounce="title" />
            <x-text-input name="author_forename" wire:model.live.debounce="author_forename" />
            <x-text-input name="author_surname" wire:model.live.debounce="author_surname" />
            <x-text-input name="co_author" wire:model.live.debounce="co_author" />
            <x-genre-input name="genre" wire:model.live.debounce="genre" />
            <x-text-input name="series" wire:model.live.debounce="series" />
            <x-number-input name="series_index" wire:model.live.debounce="series_index" />
            <x-text-input name="edition" wire:model.live.debounce="edition" />
        </div>

        <x-button type="submit">Add Book</x-button>
    </form>
</div>
