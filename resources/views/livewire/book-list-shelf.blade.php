<div class="relative">
    @if ($this->search)
        <div class="flex justify-between" wire:loading.remove>
            <p>{{ $this->books->count() }} results for search "{{ $this->search }}".</p>
            <x-button wire:click="$dispatch('book-search-set', { search: null })">Clear Search</x-button>
        </div>
    @else
        <div class="flex justify-between" wire:loading.remove>
            <p>{{ $this->books->count() }} books on the shelf.</p>
        </div>
    @endif

    <div
        wire:loading.flex
        class="pointer-events-none sticky inset-x-0 top-32 z-[35] flex flex-row items-center justify-center gap-2 bg-slate-200/5 p-2 text-center">
        @svg('heroicon-o-arrow-path', 'w-4 h-4 animate-spin') Loading
    </div>

    {{-- Controls --}}
    <div class="-mb-[6px] bg-neutral-200 p-4 text-center shadow-md dark:bg-amber-950 sm:text-left">
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

    <div class="flex flex-wrap items-end justify-center gap-y-10 overflow-hidden border-8 py-10 shadow-inner dark:border-amber-950 dark:bg-amber-800/10" id="shelf">
        @foreach ($this->books as $book)
            @if (($prev = $this->books[$loop->index - 1] ?? null) === null || $book->author_surname_char !== $prev->author_surname_char)
                <div
                    class="relative -mt-10 mb-auto flex flex-row flex-wrap self-stretch px-1 drop-shadow-[0_1px_1px_#00000030]">
                    <span class="clip-b-arrow absolute -top-[2px] z-10 -translate-x-1/2 border border-b-transparent bg-neutral-100 px-1 pb-[5px] font-mono text-sm font-bold dark:border-neutral-900 dark:bg-neutral-950">
                        {{ $book->author_surname_char }}
                    </span>
                </div>
            @endif

            <livewire:book-list-shelf-book
                :book="$book"
                :key="$book->id" />
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
