<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;

class BookPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Shelf $shelf): bool
    {
        return $user->exists && $shelf->users->contains($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shelf $shelf, Book $book): bool
    {
        return $user->exists && $shelf->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Book $book): bool
    {
        //
    }
}
