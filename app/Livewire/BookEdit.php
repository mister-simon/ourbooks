<?php

namespace App\Livewire;

use App\Actions\Shelf\UpdateBook;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BookEdit extends Component
{
    public Shelf $shelf;

    public Book $book;

    public $state = [
        'author_forename' => '',
        'author_surname' => '',
        'co_author' => '',
        'title' => '',
        'series' => '',
        'series_index' => '',
        'genre' => '',
        'edition' => '',
    ];

    public function mount()
    {
        $this->fillBook($this->book);
    }

    public function create(UpdateBook $updateBook)
    {
        Gate::authorize('update', [$this->shelf, $this->book]);

        $this->resetErrorBag();

        $updateBook->update(
            Auth::user(),
            $this->shelf,
            $this->book,
            $this->state
        );

        $this->dispatch('saved');
    }

    public function resetState()
    {
        $this->fillBook($this->book);
        $this->resetErrorBag();
    }

    public function fillBook(Book $book)
    {
        $this->state = $book->only(array_keys($this->state));
    }

    #[Computed]
    public function searchableState()
    {
        return collect($this->state)
            ->except('series_index', 'edition', 'genre')
            ->filter(fn ($attr) => trim($attr) !== '')
            ->unique();
    }

    #[Computed]
    public function search()
    {
        return $this->searchableState->join(', ', __(', or '));
    }

    #[Computed]
    public function filterIds()
    {
        if ($this->search === '') {
            return [];
        }

        return $this->searchableState
            ->map(
                fn ($searchPart) => Book::search($searchPart)
                    ->where('shelf_id', $this->shelf->id)
                    ->keys(),
            )
            ->flatten()
            ->unique();
    }

    #[Computed]
    protected function similarBooks()
    {
        return $this
            ->shelf
            ->books()
            ->orderBy('author_surname')
            ->orderBy('author_forename')
            ->orderBy('series')
            ->orderBy('series_index')
            ->orderBy('title')
            ->when($this->filterIds !== null, fn ($query) => $query->whereIn('id', $this->filterIds))
            ->where('id', '!=', $this->book->id)
            ->limit(10)
            ->get();
    }

    public function render()
    {
        $title = __('Shelf - :shelf', ['shelf' => $this->shelf->title]).' - '.$this->book->title;

        return view('livewire.book-create', [
            'title' => $title,
            'subtitle' => 'Edit Book',
        ])
            ->layout('layouts.app', [
                'title' => $title,
            ]);
    }
}
