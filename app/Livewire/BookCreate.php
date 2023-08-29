<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BookCreate extends Component
{
    protected array $searchOnUpdate = [
        'series',
        'author_surname',
        'author_forename',
        'title',
        'co_author',
    ];

    #[Locked]
    public Shelf $shelf;

    #[Rule(['required', 'string'])]
    public ?string $title = null;

    #[Rule(['nullable', 'string'])]
    public ?string $series = null;

    #[Rule(['nullable', 'integer', 'min:0'])]
    public ?int $series_index = null;

    #[Rule(['nullable', 'string'])]
    public ?string $author_surname = null;

    #[Rule(['nullable', 'string'])]
    public ?string $author_forename = null;

    #[Rule(['nullable', 'string'])]
    public ?string $genre = null;

    #[Rule(['nullable', 'string'])]
    public ?string $edition = null;

    #[Rule(['nullable', 'string'])]
    public ?string $co_author = null;

    #[Computed]
    public function users()
    {
        return $this->shelf
            ->users
            ->keyBy('id');
    }

    public function updated($property)
    {
        if (in_array($property, $this->searchOnUpdate) === false) {
            return;
        }

        $this->search();
    }

    public function search()
    {
        $data = $this->only([
            'series',
            'author_surname',
            'author_forename',
            'title',
            'co_author',
        ]);

        $this->dispatch(
            'book-search',
            search: Arr::join(array_filter($data), ' or ')
        );
    }

    public function create()
    {
        $this->authorize('create', [Book::class, $this->shelf]);

        $data = $this->validate();
        $data = Arr::map(
            $data,
            fn ($value) => $value === ''
                ? null
                : $value
        );

        $book = $this->shelf
            ->books()
            ->create($data);

        $this->dispatch('book-created', book: $book->id);

        $this->reset();
    }
}
