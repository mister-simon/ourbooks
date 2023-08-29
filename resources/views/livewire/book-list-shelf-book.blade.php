<div
    class="{{ $this->color }} relative mb-2 flex shrink flex-row border border-b-0 shadow"
    x-data="{ open: false }"
    :class="open && 'grow'">
    <button
        class="flex max-h-40 items-center justify-center self-stretch bg-black/5 px-1 py-4 dark:bg-white/10"
        @click="open = !open"
        x-on:books-list-expand.window="open = true"
        x-on:books-list-collapse.window="open = false">
        <span class="text-mode-vertical line-clamp-3 overflow-hidden text-ellipsis">
            {{ $book->title }}
        </span>
    </button>
    <div
        x-cloak
        x-show="open"
        class="custom-scrollbar max-h-40 grow origin-left overflow-auto p-4"
        x-transition:enter="transition-all ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-x-50"
        x-transition:enter-end="opacity-100 transform scale-x-100"
        x-transition:leave="transition-all ease-in duration-300"
        x-transition:leave-end="opacity-0 transform scale-x-50">

        <h4 class="font-semibold">
            {{ $this->book->title }}
        </h4>

        @if ($this->book->author_name)
            <span> {{ $this->book->author_name }}</span>
        @endif

        @if ($this->book->co_author)
            <span class="text-xs"> With {{ $this->book->co_author }}</span>
        @endif

        <div class="text-xs">
            @foreach ($this->book->only('genre', 'series_text', 'edition') as $attribute => $value)
                <p>{{ str($attribute)->replace('_', ' ')->title() }}: {{ $value }}</p>
            @endforeach
        </div>
    </div>
    <hr class="absolute -inset-x-0 top-full z-20 w-[200vw] -translate-x-1/2 border-b-4 border-t-4 border-b-slate-300 dark:border-b-amber-950 dark:border-t-amber-900" role="presentation">
</div>
