<?php

namespace App\Actions\Shelf;

use App\Models\Shelf;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateBook
{
    #[Rule([])]
    public ?string $title = null;

    #[Rule([])]
    public ?string $series = null;

    #[Rule([])]
    public ?int $series_index = null;

    #[Rule([])]
    public ?string $author_surname = null;

    #[Rule([])]
    public ?string $author_forename = null;

    #[Rule([])]
    public ?string $genre = null;

    #[Rule([])]
    public ?string $edition = null;

    #[Rule([])]
    public ?string $co_author = null;

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
