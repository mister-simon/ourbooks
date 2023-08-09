<?php

namespace App\Helpers;

use App\Models\Shelf;

final class ShelfUserSession
{
    public static function set(Shelf $shelf, string $user)
    {
        session()->put("shelf.{$shelf->id}", $user);
    }

    public static function get(Shelf $shelf)
    {
        return session("shelf.{$shelf->id}", null);
    }
}
