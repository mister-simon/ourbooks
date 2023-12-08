<?php

namespace App\Livewire;

use App\Enums\ReadStatus;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class ShelfShow extends Component
{
    public Shelf $shelf;

    #[Url('q', true)]
    public $search = '';

    public Collection $checkedBooks;

    public function mount()
    {
        $invite = $this
            ->shelf
            ->invites
            ->firstWhere('user_id', Auth::id());

        if ($invite) {
            return to_route('shelves.invite.confirm', ['invite' => $invite->id]);
        }

        $this->checkedBooks = collect([]);

        $this->authorize('view', $this->shelf);
    }

    public function rateMany(array $books, Shelf $shelf, $rating)
    {
        // Auth
        $user = Auth::user();
        Gate::authorize('rateBooks', $shelf);

        // Validation
        validator([
            'books' => collect($books)->map(fn ($id) => ['id' => $id])->all(),
        ], [
            'books' => ['array'],
            'books.*.id' => [
                Rule::exists(Book::class)
                    ->where('shelf_id', $shelf->id),
            ],
        ])->validate();

        // Do update
        DB::transaction(function () use ($user, $books, $rating) {
            // Add any missing UserRating pivot models
            $existingRatings = $user->bookUsers()
                ->whereIn('book_id', $books)
                ->pluck('book_id');

            $missingBooks = collect($books)
                ->diff($existingRatings);

            $user->bookUsers()
                ->createMany(
                    $missingBooks->map(
                        fn ($id) => ['book_id' => $id]
                    )
                );

            // Update all relevant UserRating models
            $existingRatings = $user->bookUsers()
                ->whereIn('book_id', $books)
                ->update(['rating' => $rating]);
        });

    }

    public function readMany(array $books, Shelf $shelf, $readStatus)
    {
        // Auth
        $user = Auth::user();
        Gate::authorize('readBooks', $shelf);

        // Do validation
        validator([
            'books' => collect($books)->map(fn ($id) => ['id' => $id])->all(),
            'read' => $readStatus,
        ], [
            'books' => ['array'],
            'books.*.id' => [
                Rule::exists(Book::class)
                    ->where('shelf_id', $shelf->id),
            ],
            'read' => [Rule::enum(ReadStatus::class)],
        ])->validate();

        // Do update
        DB::transaction(function () use ($user, $books, $readStatus) {
            // Add any missing UserRating pivot models
            $existingRatings = $user->bookUsers()
                ->whereIn('book_id', $books)
                ->pluck('book_id');

            $missingBooks = collect($books)
                ->diff($existingRatings);

            $user->bookUsers()
                ->createMany(
                    $missingBooks->map(
                        fn ($id) => ['book_id' => $id]
                    )
                );

            // Update all relevant UserRating models
            $existingRatings = $user->bookUsers()
                ->whereIn('book_id', $books)
                ->update(['read' => $readStatus]);
        });
    }

    #[Computed]
    protected function filteredBooks()
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
