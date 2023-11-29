<?php

namespace App\Actions\Shelf;

use App\Models\Shelf;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UpdateShelf
{
    public function update(User $user, Shelf $shelf, array $input)
    {
        $data = Validator::make(
            $input,
            ['title' => ['required', 'string']]
        )->validate();

        return $shelf->update($data);
    }
}
