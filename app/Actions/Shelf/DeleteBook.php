<?php

namespace App\Actions\Shelf;

use App\Models\Book;

class DeleteBook
{
    public function delete(Book $book)
    {
        return $book->delete();
    }
}
