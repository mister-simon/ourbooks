<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BookListTableBook extends Component
{
    #[Locked]
    public Book $book;

    #[Locked]
    public ?Book $nextBook = null;

    public bool $edit = false;

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

    public function mount(Book $book)
    {
        $this->book = $book;

        $this->fill(
            $book->only(
                'title',
                'series',
                'series_index',
                'author_surname',
                'author_forename',
                'genre',
                'edition',
                'co_author',
            ),
        );
    }

    #[Computed()]
    public function rowClasses()
    {
        if ($this->nextBook && $this->nextBook->authorName !== $this->book->authorName) {
            return 'border-neutral-500 dark:border-neutral-200';
        }

        return 'border-neutral-200 dark:border-neutral-500';
    }

    public function save()
    {
        $this->authorize('update', $this->book);

        $data = $this->validate();

        $data = Arr::map(
            $data,
            fn ($value) => $value === ''
                ? null
                : $value
        );

        $this->book->update($data);

        $this->dispatch('book-updated', book: $this->book->id);

        $this->edit = false;
    }
}
