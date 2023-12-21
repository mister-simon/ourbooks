<?php

namespace App\Livewire;

use App\Actions\Shelf\BulkBookActions;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class ShelfShow extends Component
{
    public Shelf $shelf;

    #[Url('q', true)]
    public $search = '';

    public function mount()
    {
        $invite = $this
            ->shelf
            ->invites
            ->firstWhere('user_id', Auth::id());

        if ($invite) {
            return to_route('shelves.invite.confirm', ['invite' => $invite->id]);
        }

        $this->authorize('view', $this->shelf);
    }

    public function rateMany(array $books, Shelf $shelf, $rating, BulkBookActions $bookActions)
    {
        // Auth
        $user = Auth::user();
        Gate::authorize('rateBooks', $shelf);

        $this->validateShelfHasBooks($books, $shelf);
        $bookActions->rate($books, $user, $rating);

        $this->dispatch('saved');
    }

    public function readMany(array $books, Shelf $shelf, $readStatus, BulkBookActions $bookActions)
    {
        // Auth
        $user = Auth::user();
        Gate::authorize('readBooks', $shelf);

        $this->validateShelfHasBooks($books, $shelf);
        $bookActions->read($books, $user, $readStatus);

        $this->dispatch('saved');
    }

    protected function validateShelfHasBooks(array $books, Shelf $shelf)
    {
        $bookCount = $shelf->books()
            ->whereIn('id', $books)
            ->count();

        throw_unless(
            $bookCount === count($books),
            ValidationException::withMessages([
                'books' => __(
                    'The selected :attribute are invalid.',
                    ['attribute' => __('books')]
                ),
            ])
        );
    }

    #[Computed]
    public function filteredBooksByAuthor()
    {
        return $this->filteredBooks
            ->groupBy('author_surname_char');
    }

    #[Computed]
    public function filteredBooks()
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
            ->with('bookUsers.user')
            ->get();
    }

    #[Computed]
    public function filterIds()
    {
        if (! $this->search) {
            return null;
        }

        $searchIds = str($this->search)
            ->explode(' or ')
            ->unique()
            ->take(10)
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
    public function filteredBooksCount()
    {
        return $this->filteredBooks->count();
    }

    public function placeholder(array $params = [])
    {
        return view('partials.loading-page', [
            'title' => __('Shelf - :shelf', ['shelf' => $params['shelf']->title]),
            'message' => 'Loading all your books',
            ...$params,
        ]);
    }

    public function render()
    {
        return view('livewire.shelf-show')
            ->layout('layouts.app', [
                'title' => __('Shelf - :shelf', ['shelf' => $this->shelf->title]),
            ]);
    }
}
