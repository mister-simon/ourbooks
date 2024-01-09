<?php

namespace App\Actions\BookUser;

use App\Enums\ReadStatus;
use App\Models\BookUser;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateBookUser
{
    public function update(User $user, Shelf $shelf, BookUser $bookUser, array $input)
    {

        $data = Validator::make(
            $input,
            [
                'rating' => ['numeric', 'between:0,10'],
                'read' => [Rule::enum(ReadStatus::class)],
                'comments' => ['nullable', 'string', 'max:10000'],
            ]
        )->validate();

        return $bookUser->update([
            'rating' => $data['rating'],
            'read' => $data['read']->value,
            'comments' => $data['comments'],
        ]);
    }
}
