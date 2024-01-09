<?php

namespace App\Livewire;

use App\Actions\Book\CreateBook;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BookCreate extends Component
{
    public Shelf $shelf;

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

    public function create(CreateBook $createBook, $addAnother = false)
    {
        Gate::authorize('create', [Book::class, $this->shelf]);

        $this->resetErrorBag();

        $createBook->create(
            Auth::user(),
            $this->shelf,
            $this->state
        );

        $this->dispatch('saved');

        if ($addAnother) {
            $this->state['title'] = '';
            $this->resetErrorBag();

            return;
        }

        return to_route('shelves.show', ['shelf' => $this->shelf]);
    }

    public function resetState()
    {
        $this->reset('state');
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
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.book-create')
            ->layout('layouts.app', [
                'title' => $this->shelf->title.' - '.__('Create Book'),
            ]);
    }
}
