<?php

namespace App\Policies;

use App\Models\Shelf;
use App\Models\User;

class ShelfPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shelf $shelf): bool
    {
        return $shelf->users->contains($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shelf $shelf): bool
    {
        return $shelf->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shelf $shelf): bool
    {
        return $shelf->users->contains($user);
    }

    public function rateBooks(User $user, Shelf $shelf): bool
    {
        return $shelf->users->contains($user);
    }

    public function readBooks(User $user, Shelf $shelf): bool
    {
        return $shelf->users->contains($user);
    }

    public function commentBooks(User $user, Shelf $shelf): bool
    {
        return $shelf->users->contains($user);
    }
}
