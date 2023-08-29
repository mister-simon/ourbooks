<div class="relative">
    @if ($this->search)
        <div class="flex justify-between">
            <p>{{ $this->books->count() }} results for search "{{ $this->search }}".</p>
            <x-button wire:click="$dispatch('book-search-set', { search: null })">Clear Search</x-button>
        </div>
    @else
        <div class="flex justify-between">
            <p>{{ $this->books->count() }} books on the shelf.</p>
        </div>
    @endif

    {{-- Controls --}}
    <div class="sticky inset-x-0 top-10 z-20 -mb-[6px] bg-amber-950 p-4 text-center shadow-md sm:text-left lg:top-14">
        <x-button
            class="inline-flex gap-2 !px-2 shadow-lg"
            wire:click="$dispatch('books-list-expand')">
            @svg('heroicon-o-chevron-double-right', 'w-4 h-4') Expand All
        </x-button>
        <x-button
            class="inline-flex gap-2 !px-2 shadow-lg"
            wire:click="$dispatch('books-list-collapse')">
            @svg('heroicon-o-chevron-double-left', 'w-4 h-4') Collapse All
        </x-button>
    </div>

    <div class="flex flex-wrap items-end justify-center gap-y-10 overflow-hidden border-8 border-amber-950 bg-amber-800/10 py-10 shadow-inner" id="shelf">

        {{-- Books by Surname char --}}
        @foreach ($this->groupedBooks as $char => $group)
            <div class="relative -mt-10 mb-auto flex flex-row flex-wrap self-stretch px-1 drop-shadow-[0_1px_1px_#000]">
                <span class="clip-b-arrow absolute top-0 -translate-x-1/2 border border-b-transparent bg-neutral-100 px-1 pb-[5px] font-mono text-sm font-bold dark:border-neutral-900 dark:bg-neutral-950">
                    {{ $char }}
                </span>
            </div>
            @foreach ($group as $book)
                <livewire:book-list-shelf-book
                    :book="$book"
                    :key="'shelfBook-' . $book->id" />
            @endforeach
        @endforeach

        {{-- No books --}}
        @if ($this->books->isEmpty())
            <div class="relative -mt-10 mb-auto flex flex-row flex-wrap self-stretch drop-shadow-[0_1px_1px_#000]">
                <span class="clip-b-arrow absolute top-0 mx-1 border border-b-transparent bg-neutral-100 px-1 pb-4 font-mono text-sm font-bold dark:border-neutral-900 dark:bg-neutral-950">
                    No books here...
                </span>
            </div>
            <div class="mt-40 grow border-b-4 border-t-4 border-b-amber-950 border-t-amber-900"></div>
        @endif
    </div>
</div>
