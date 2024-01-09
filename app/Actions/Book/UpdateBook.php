<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UpdateBook
{
    public function update(User $user, Shelf $shelf, Book $book, array $input)
    {
        $data = Validator::make(
            $input,
            [
                'title' => ['required', 'string'],
                'series' => ['nullable', 'string'],
                'series_index' => ['nullable', 'integer', 'min:0'],
                'author_surname' => ['nullable', 'string'],
                'author_forename' => ['nullable', 'string'],
                'genre' => ['nullable', 'string'],
                'edition' => ['nullable', 'string'],
                'co_author' => ['nullable', 'string'],
            ]
        )->validate();

        return $book->update($data);
    }
}
