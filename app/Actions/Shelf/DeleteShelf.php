<?php

namespace App\Actions\Shelf;

use App\Models\Shelf;

class DeleteShelf
{
    public function delete(Shelf $shelf)
    {
        return $shelf->delete();
    }
}
