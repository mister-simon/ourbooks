<?php

namespace App\Actions\Shelf;

use App\Models\Shelf;
use App\Models\ShelfInvite;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateShelfInvite
{
    public function invite(User $user, Shelf $shelf, array $input)
    {
        $data = Validator::make(
            $input,
            ['email' => ['required', 'email']]
        )->validate();

        $user = User::where('email', $data['email'])
            ->first();

        ShelfInvite::firstOrCreate([
            'email' => $data['email'],
            'shelf_id' => $shelf->id,
        ], [
            'user_id' => $user?->id,
        ]);
    }
}
