<?php

namespace App\Livewire;

use App\Actions\BookUser\UpdateBookUser;
use App\Enums\ReadStatus;
use App\Helpers\PrepareInput;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class BookShow extends Component
{
    public Shelf $shelf;

    public Book $book;

    public ?BookUser $bookUser;

    public $state = [
        'rating' => '',
        'read' => '',
        'comments' => '',
    ];

    public function mount(Shelf $shelf, Book $book)
    {
        $this->shelf = $shelf;
        $this->book = $book->load('bookUsers.user');

        $this->bookUser = $this->book
            ->bookUsers
            ->firstWhere('user_id', Auth::id());

        if ($this->bookUser === null) {
            $this->bookUser = $this->book
                ->bookUsers()
                ->firstOrCreate(['user_id' => Auth::id()]);
        }

        $this->state = [
            'rating' => $this->bookUser->rating ?? 0,
            'read' => $this->bookUser->read ?? ReadStatus::UNKNOWN,
            'comments' => $this->bookUser->comments,
        ];
    }

    public function hydrate()
    {
        $this->book = $this->book->load('bookUsers.user');
    }

    public function editBookUser(UpdateBookUser $updater)
    {
        Gate::authorize('rateBooks', [$this->shelf]);
        Gate::authorize('readBooks', [$this->shelf]);
        Gate::authorize('commentBooks', [$this->shelf]);

        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->shelf,
            $this->bookUser,
            PrepareInput::process($this->state)
        );

        $this->dispatch('saved');
    }

    public function render()
    {
        $title = $this->shelf->title.' - '.$this->book->title;

        return view('livewire.book-show', [
            'title' => $title,
            'subtitle' => 'Edit Book',
            'profilePhotos' => Jetstream::managesProfilePhotos(),
            'book' => $this->book,
        ])
            ->layout('layouts.app', [
                'title' => $title,
            ]);
    }
}
