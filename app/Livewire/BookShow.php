<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Shelf;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class BookShow extends Component
{
    public Shelf $shelf;

    public Book $book;

    public function mount(Book $book)
    {
        $this->book = $book->load(
            'bookUsers.user'
        );
    }

    public function render()
    {
        $title = $this->shelf->title.' - '.$this->book->title;

        return view('livewire.book-show', [
            'title' => $title,
            'subtitle' => 'Edit Book',
            'profilePhotos' => Jetstream::managesProfilePhotos(),
        ])
            ->layout('layouts.app', [
                'title' => $title,
            ]);
    }
}
