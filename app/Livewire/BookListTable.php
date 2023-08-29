<?php

namespace App\Livewire;

use App\Livewire\Traits\HasBookList;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BookListTable extends Component
{
    use HasBookList;

    #[Computed]
    public function groupedBooks()
    {
        return $this->books->groupBy('authorSurnameChar');
    }

    public function render()
    {
        return view('livewire.book-list-table');
    }
}
