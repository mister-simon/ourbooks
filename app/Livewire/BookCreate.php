<?php

namespace App\Livewire;

use App\Actions\Shelf\CreateBook;
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
        'author_surname' => '',
        'author_forename' => '',
        'co_author' => '',
        'series' => '',
        'series_index' => '',
        'title' => '',
        'genre' => '',
        'edition' => '',
    ];

    public function create(CreateBook $createBook)
    {
        Gate::authorize('create', [Book::class, $this->shelf]);

        $this->resetErrorBag();

        $book = $createBook->create(
            Auth::user(),
            $this->shelf,
            $this->state
        );

        $this->reset('state');
        $this->dispatch('saved');
    }

    #[Computed]
    public function search()
    {
        return collect($this->state)
            ->join(' or ');
    }

    #[Computed]
    public function filterIds()
    {
        $searchIds = collect($this->state)
            ->map(
                fn ($searchPart) => Book::search($searchPart)
                    ->where('shelf_id', $this->shelf->id)
                    ->keys(),
            )
            ->flatten()
            ->unique();

        return $searchIds;
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
                'title' => __('Shelf - :shelf', ['shelf' => $this->shelf->title]).__(' - Create Book'),
            ]);
    }
}
