<?php

use function Livewire\Volt\{state, computed};

state(['books' => fn() => $books]);

$groupedBooks = computed(fn() => $this->books->groupBy('authorSurnameChar'));

?>

<div class="flex flex-wrap items-end justify-center gap-y-10 overflow-hidden border-8 border-amber-950 bg-amber-800/10 py-10 shadow-inner" id="shelf">
    @foreach ($this->groupedBooks as $char => $group)
        <div class="relative -mt-10 mb-auto flex flex-row flex-wrap self-stretch px-1">
            <span class="clip-b-arrow absolute top-0 -translate-x-1/2 border border-neutral-900 border-b-transparent bg-neutral-950 px-1 pb-[5px] font-mono text-sm font-bold">
                {{ $char }}
            </span>
        </div>
        @foreach ($group as $book)
            <livewire:book-list-shelf-book :book="$book" />
        @endforeach
    @endforeach
</div>
