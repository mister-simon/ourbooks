<?php

use function Livewire\Volt\{state};

state(['layouts' => [
    'list' => 'book-list-list',
    'grid' => 'book-list-grid',
    'shelf' => 'book-list-shelf',
]]);

state(['books' => fn() => $books]);
state(['layout' => 'list']);

?>

<div>
    @livewire($layouts[$this->layout], ['books' => $this->books])
</div>
