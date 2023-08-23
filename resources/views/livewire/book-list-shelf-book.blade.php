<?php

use function Livewire\Volt\{state, computed};

state(['book' => fn() => $book])->locked();
state(['colors' => ['border-slate-300 bg-slate-300 dark:border-slate-600 dark:bg-slate-600', 'border-slate-300 bg-slate-100 dark:border-slate-900 dark:bg-slate-900', 'border-zinc-300 bg-zinc-200 dark:border-zinc-500 dark:bg-zinc-500', 'border-neutral-300 bg-neutral-300 dark:border-neutral-600 dark:bg-neutral-600', 'border-neutral-300 bg-neutral-200 dark:border-neutral-800 dark:bg-neutral-800', 'border-orange-300 bg-orange-200 dark:border-orange-800 dark:bg-orange-800', 'border-green-300 bg-green-200 dark:border-green-800 dark:bg-green-800', 'border-sky-300 bg-sky-200 dark:border-sky-800 dark:bg-sky-800', 'border-rose-300 bg-rose-200 dark:border-rose-800 dark:bg-rose-800', 'border-teal-300 bg-teal-200 dark:border-teal-800 dark:bg-teal-800', 'border-teal-300 bg-teal-200 dark:border-teal-900 dark:bg-teal-900', 'border-green-300 bg-green-200 dark:border-green-900 dark:bg-green-900']])->locked();

$colorIndex = computed(function () {
    $length = count($this->colors);
    return $this->book->integer_hash % $length;
});

$color = computed(function () {
    return $this->colors[$this->colorIndex];
});

?>

<div
    class="{{ $this->color }} relative mb-2 flex shrink flex-row border border-b-0"
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
    <hr class="absolute -inset-x-0 top-full w-[200vw] -translate-x-1/2 border-b-4 border-t-4 border-b-amber-950 border-t-amber-900" role="presentation">
</div>
