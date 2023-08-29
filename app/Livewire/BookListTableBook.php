<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class BookListTableBook extends Component
{
    #[Locked]
    public Book $book;

    #[Locked]
    public ?Book $nextBook = null;

    #[Computed()]
    public function rowClasses()
    {
        if ($this->nextBook && $this->nextBook->authorName !== $this->book->authorName) {
            return 'border-neutral-500 dark:border-neutral-200';
        }

        return 'border-neutral-200 dark:border-neutral-500';
    }
}
