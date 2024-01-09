<?php

namespace App\Actions\Book;

use App\Models\Shelf;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateBook
{
    public function create(User $user, Shelf $shelf, array $input)
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

        return $shelf
            ->books()
            ->create($data);
    }
}
