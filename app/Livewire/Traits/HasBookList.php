<?php

namespace App\Livewire\Traits;

use App\Models\Book;
use App\Models\Shelf;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;

trait HasBookList
{
    #[Locked]
    public Shelf $shelf;

    #[Reactive]
    public ?string $search = null;

    #[Computed]
    public function filterIds()
    {
        if (! $this->search) {
            return null;
        }

        $searchIds = str($this->search)
            ->explode(' or ')
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
    public function books()
    {
        return $this->shelf
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
}
