<?php

namespace App\Policies;

use App\Models\Shelf;
use App\Models\ShelfInvite;
use App\Models\User;

class ShelfInvitePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Shelf $shelf): bool
    {
        return $user->exists && $shelf->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShelfInvite $shelfInvite): bool
    {
        $isAuthUser = fn () => $shelfInvite
            ->user()
            ->is($user);

        $isShelfAdmin = fn () => $shelfInvite
            ->shelf
            ->users
            ->contains($user);

        return $isAuthUser() || $isShelfAdmin();
    }

    public function confirm(User $user, ShelfInvite $shelfInvite): bool
    {
        return $shelfInvite->user()->is($user);
    }
}
