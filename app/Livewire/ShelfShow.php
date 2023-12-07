<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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

    public function checkAll($checked)
    {
        $keys = $this->filteredBooks->modelKeys();

        if ($checked) {
            $this->checkedBooks = $this->checkedBooks->union($keys);

            return;
        }

        $this->checkedBooks = $this->checkedBooks->diff($keys);
    }

    public function checkLetter($letter, $checked)
    {
        $keys = $this->filteredBooks()
            ->where('author_surname_char', $letter)
            ->modelKeys();

        if ($checked) {
            $this->checkedBooks = $this->checkedBooks->union($keys);

            return;
        }

        $this->checkedBooks = $this->checkedBooks->diff($keys);
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
