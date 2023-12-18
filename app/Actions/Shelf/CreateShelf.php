<?php

namespace App\Actions\Shelf;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateShelf
{
    public function create(User $user, array $input)
    {
        $data = Validator::make(
            $input,
            ['title' => ['required', 'string']]
        )->validate();

        return $user
            ->shelves()
            ->create($data);
    }
}
