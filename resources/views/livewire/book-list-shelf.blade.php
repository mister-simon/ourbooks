<?php

use function Livewire\Volt\{state, computed};

state(['books' => fn() => $books]);

?>

<div class="flex flex-wrap items-end justify-center gap-y-10 overflow-hidden border-8 border-amber-950 bg-amber-800/10 py-6 shadow-inner" id="shelf">
    @foreach ($this->books as $book)
        <livewire:book-list-shelf-book :book="$book" />
    @endforeach
</div>
