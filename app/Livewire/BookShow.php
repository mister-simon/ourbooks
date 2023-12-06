<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Shelf;
use Livewire\Component;

class BookShow extends Component
{
    public Shelf $shelf;

    public Book $book;

    public function render()
    {
        $title = $this->shelf->title.' - '.$this->book->title;

        return view('livewire.book-show', [
            'title' => $title,
            'subtitle' => 'Edit Book',
        ])
            ->layout('layouts.app', [
                'title' => $title,
            ]);
    }
}
