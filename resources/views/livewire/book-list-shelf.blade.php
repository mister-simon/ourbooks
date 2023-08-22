<?php

use function Livewire\Volt\{state, computed};

state(['books' => fn() => $books]);

?>

<div class="flex flex-wrap items-end gap-y-2" id="shelf">
    @foreach ($this->books as $book)
        <livewire:book-list-shelf-book :book="$book" />
    @endforeach
</div>
