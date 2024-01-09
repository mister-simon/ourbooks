<?php

namespace App\Actions\BookUser;

use App\Enums\ReadStatus;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BulkBookActions
{
    public function rate(array $books, User $user, int $rating)
    {
        // Validation
        Validator::make([
            'books' => $books,
            'rating' => $rating,
        ], [
            'books' => ['required', 'array', 'min:1'],
            'rating' => ['numeric', 'between:0,10'],
        ])->validate();

        $this->validateBooksExist($books);

        // Do update
        DB::transaction(function () use ($user, $books, $rating) {
            // Add any missing book user pivot models
            $this->ensureBookUsersExist($books, $user);

            // Update all relevant book user models
            $user->bookUsers()
                ->whereIn('book_id', $books)
                ->update(['rating' => $rating]);
        });
    }

    public function read(array $books, User $user, $readStatus)
    {
        // Validation
        Validator::make([
            'books' => $books,
            'read' => $readStatus,
        ], [
            'books' => ['required', 'array', 'min:1'],
            'read' => [Rule::enum(ReadStatus::class)],
        ])->validate();

        $readStatus = ReadStatus::from($readStatus);

        $this->validateBooksExist($books);

        // Do update
        DB::transaction(function () use ($user, $books, $readStatus) {
            // Add any missing book user pivot models
            $this->ensureBookUsersExist($books, $user);

            // Update all relevant book user models
            $user->bookUsers()
                ->whereIn('book_id', $books)
                ->update(['read' => $readStatus]);
        });
    }

    protected function validateBooksExist(array $books)
    {
        throw_if(
            Book::whereIn('id', $books)->count() !== count($books),
            ValidationException::withMessages(['books' => __('The selected :attribute are invalid.', ['attribute' => __('books')])])
        );
    }

    protected function ensureBookUsersExist(array $books, User $user)
    {
        // Diff the user's existing books from those provided
        $existingRatings = $user->bookUsers()
            ->whereIn('book_id', $books)
            ->pluck('book_id');

        $missingBooks = collect($books)
            ->diff($existingRatings);

        // Create missing user books with defaults
        $user->bookUsers()
            ->createMany(
                $missingBooks->map(fn ($id) => ['book_id' => $id])
            );
    }
}
