<?php

namespace App\Actions\Book;

use App\Models\Book;

class DeleteBook
{
    public function delete(Book $book)
    {
        return $book->delete();
    }
}
