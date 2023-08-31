<div
    class="{{ $this->color }} relative mb-2 flex shrink flex-row border border-b-0 shadow"
    x-data="{ open: false }"
    :class="open && 'grow'">
    <button
        class="{{ $this->edit ? '' : 'max-h-60' }} flex items-center justify-center self-stretch bg-black/5 px-1 py-4 dark:bg-white/10"
        x-on:click="
            open = !open
            setTimeout(() => $el.scrollIntoView({ block: 'center', behavior: 'smooth' }), 100)
        "
        x-on:books-list-expand.window="open = true"
        x-on:books-list-collapse.window="open = false"
        wire:click="save">
        <span class="text-mode-vertical line-clamp-3 overflow-hidden text-ellipsis">
            {{ $book->title }}
        </span>
    </button>

    <div
        x-cloak
        x-show="open"
        class="custom-scrollbar {{ $this->edit ? '' : '' }} relative grow origin-left overflow-auto p-4 pr-12"
        x-transition:enter="transition-all ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-x-50"
        x-transition:enter-end="opacity-100 transform scale-x-100"
        x-transition:leave="transition-all ease-in duration-300"
        x-transition:leave-end="opacity-0 transform scale-x-50">

        <div class="absolute right-2 top-2">
            @if ($this->edit)
                <x-button
                    wire:click="save"
                    class="block w-full !bg-success !p-2"
                    wire:loading.attr="disabled">
                    <span wire:loading.delay wire:target="save">
                        @svg('heroicon-o-arrow-path', 'w-4 h-4 animate-spin')
                    </span>
                    <span wire:loading.delay.remove wire:target="save">
                        @svg('heroicon-o-check', 'w-4 h-4')
                    </span>
                </x-button>
            @else
                <x-button
                    wire:click="$set('edit', true)"
                    class="block w-full !p-2">
                    <span wire:loading.delay>
                        @svg('heroicon-o-arrow-path', 'w-4 h-4 animate-spin')
                    </span>
                    <span wire:loading.delay.remove>
                        @svg('heroicon-o-pencil-square', 'w-4 h-4')
                    </span>
                </x-button>
            @endif
        </div>

        @if ($this->edit)
            <form wire:submit="save">
                <x-text-input
                    wire:model="author_surname"
                    name="author_surname"
                    :id="'author_surname-' . $this->book->id"
                    x-data
                    x-init="$nextTick(() => $el.focus())" />

                <x-text-input
                    wire:model="author_forename"
                    name="author_forename"
                    :id="'author_forename-' . $this->book->id" />

                <div class="-my-3 flex flex-row justify-stretch gap-2">
                    <x-text-input
                        wire:model="series"
                        name="series"
                        :id="'series-' . $this->book->id"
                        wrapperClasses="grow" />

                    <x-number-input
                        wire:model="series_index"
                        label="Index"
                        name="series_index"
                        :id="'series_index-' . $this->book->id"
                        min="0"
                        wrapperClasses="grow" />
                </div>

                <x-text-input
                    wire:model="title"
                    name="title"
                    :id="'title-' . $this->book->id" />

                <x-text-input
                    wire:model="genre"
                    name="genre"
                    :id="'genre-' . $this->book->id" />

                <x-text-input
                    wire:model="edition"
                    name="edition"
                    :id="'edition-' . $this->book->id" />

                <x-text-input
                    wire:model="co_author"
                    name="co_author"
                    :id="'co_author-' . $this->book->id" />

                <button type="submit"></button>
            </form>
        @else
            <div>
                <h3 class="font-semibold">
                    {{ $this->book->title }}
                </h3>

                @if ($this->book->author_name)
                    <span> {{ $this->book->author_name }}</span>
                @endif

                @if ($this->book->co_author)
                    <span class="text-xs"> With {{ $this->book->co_author }}</span>
                @endif

                <div class="text-xs">
                    @foreach ($this->book->only('genre', 'series_text', 'edition') as $attribute => $value)
                        <p>{{ $value }}</p>
                    @endforeach
                </div>

                <x-hr />

                @if ($this->book->bookUsers->isNotEmpty())
                    <table>
                        <tr class="font-semibold">
                            <td class="px-1">Average</td>
                            <td class="px-1">{{ $this->book->book_user_avg_rating }}</td>
                            <td class="px-1"><x-rating :value="$this->book->book_user_avg_rating" class="inline-flex" /></td>
                        </tr>

                        @foreach ($this->book->bookUsers as $bookUser)
                            <tr class="text-sm">
                                <td class="px-1">{{ $bookUser->user->readable }}</td>
                                <td class="px-1">{{ $bookUser->rating }}</td>
                                <td class="px-1"><x-rating :value="$bookUser->rating" class="inline-flex" /></td>
                                <td class="px-1">{{ ucwords($bookUser->read->trans()) }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif

                <x-number-input
                    wire:model.live="rating"
                    label="Rating"
                    name="rating"
                    :id="'rating-' . $this->book->id"
                    min="0"
                    max="10" />

                @foreach (\App\Enums\ReadStatus::select() as $key => $val)
                    <label for="{{ 'read-' . $key . $this->book->id }}">
                        <input
                            type="radio"
                            name="read"
                            value="{{ $key }}"
                            id="{{ 'read-' . $key . $this->book->id }}"
                            wire:model.live="read"> {{ ucwords($val) }}
                    </label>
                @endforeach
            </div>
        @endif
    </div>
    <hr class="absolute -inset-x-0 top-full z-20 w-[200vw] -translate-x-1/2 border-b-4 border-t-4 border-b-slate-300 dark:border-b-amber-950 dark:border-t-amber-900" role="presentation">
</div>
