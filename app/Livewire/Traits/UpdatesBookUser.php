<?php

namespace App\Livewire\Traits;

use App\Enums\ReadStatus;
use App\Models\BookUser;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;

trait UpdatesBookUser
{
    #[Locked]
    public ?BookUser $bookUser = null;

    #[Rule(['nullable', 'numeric', 'between:0,10', 'decimal:0,2'])]
    public ?float $rating = null;

    #[Rule(['nullable', new Enum(ReadStatus::class)])]
    public ?ReadStatus $read = null;

    public function mountUpdatesBookUser(BookUser $bookUser)
    {
        /**
         * @var \App\Models\Book
         */
        $book = $this->book;
        $userId = auth()->id();

        $bookUser = $book
            ->bookUsers
            ->firstWhere('user_id', $userId);

        $this->fill(
            [
                'rating' => $bookUser?->rating,
                'read' => $bookUser?->read,
            ],
        );
    }

    public function updatedUpdatesBookUser($attribute, $value)
    {
        if (! in_array($attribute, ['rating', 'read'])) {
            return;
        }

        $this->validateOnly($attribute);

        return $this->rate();
    }

    public function rate()
    {
        $this->authorize('rate', $this->book);

        $data = $this->validate();

        $data = Arr::map(
            $data,
            fn ($value) => $value === ''
                ? null
                : $value
        );

        $this->book
            ->users()
            ->updateExistingPivot(
                auth()->id(),
                $data
            );

        $this->book->load('bookUsers');

        $this->dispatch('book-updated', book: $this->book->id);
    }
}
