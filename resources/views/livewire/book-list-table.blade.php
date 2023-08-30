<div class="relative">

    @if ($this->search)
        <div class="flex justify-between" wire:loading.remove>
            <p>{{ $this->books->count() }} results for search "{{ $this->search }}".</p>
            <x-button wire:click="$dispatch('book-search-set', { search: null })">Clear Search</x-button>
        </div>
    @else
        <div class="flex justify-between" wire:loading.remove>
            <p>{{ $this->books->count() }} books displayed.</p>
        </div>
    @endif

    <div
        wire:loading.flex
        class="pointer-events-none sticky inset-x-0 top-20 flex flex-row items-center justify-center gap-2 bg-slate-200/5 p-2 text-center">
        @svg('heroicon-o-arrow-path', 'w-4 h-4 animate-spin') Loading
    </div>

    <div class="max-w-full overflow-auto">
        <table class="w-full table-auto overflow-auto text-left text-sm font-light">
            <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-2">Surname</th>
                    <th scope="col" class="border-r px-6 py-2">Forename</th>
                    <th scope="col" class="px-6 py-2">Series</th>
                    <th scope="col" class="border-r px-6 py-2">Title</th>
                    <th scope="col" class="px-6 py-2">Genre</th>
                    <th scope="col" class="px-6 py-2">Edition</th>
                    <th scope="col" class="px-6 py-2">Co Author</th>
                    <th scope="col" class="px-6 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->books as $book)
                    @if (($prev = $this->books[$loop->index - 1] ?? null) === null || $book->author_surname_char !== $prev->author_surname_char)
                        <tr>
                            <td colspan="100%" class="whitespace-nowrap border-y bg-neutral-100 px-6 text-center transition duration-300 ease-in-out dark:bg-neutral-600">{{ $book->author_surname_char }}</td>
                        </tr>
                    @endif

                    <livewire:book-list-table-book
                        :book="$book"
                        :next-book="$group[$loop->index + 1] ?? null"
                        :key="$book->id" />
                @empty
                    <tr>
                        <td width="100%">No books here...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
