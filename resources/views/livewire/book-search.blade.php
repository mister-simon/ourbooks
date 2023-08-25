<div>
    <form>
        <div class="flex items-center gap-2">
            <x-text-input
                name="search"
                wire:model.live.debounce="search" />

            <x-button
                type="submit"
                class="mt-6 inline-flex flex-row items-center gap-2">
                @svg('heroicon-o-magnifying-glass', 'w-4 h-4') Search
            </x-button>
        </div>
    </form>
</div>
