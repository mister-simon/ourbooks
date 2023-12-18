<?php

namespace App\Actions\Shelf;

use App\Models\Shelf;
use App\Models\ShelfInvite;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateShelfInvite
{
    public function invite(User $invitedBy, Shelf $shelf, array $input)
    {
        $data = Validator::make(
            $input,
            [
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
            ],
            [
                'name.required' => __('Providing a name makes it less likely the notification will be marked as spam.'),
            ]
        )->validate();

        $user = User::where('email', $data['email'])
            ->first();

        if ($shelf->users->contains($user)) {
            return;
        }

        $invite = ShelfInvite::query()
            ->updateOrCreate([
                'email' => $data['email'],
                'shelf_id' => $shelf->id,
            ], [
                'invited_by_id' => $invitedBy->id,
                'user_id' => $user?->id,
                'name' => $data['name'],
            ]);

        if ($invite->wasRecentlyCreated) {
            $invite->notifyUser();
        }
    }
}
