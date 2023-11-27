<?php

namespace App\Livewire;

use App\Models\Shelf;
use Livewire\Component;

class BookCreate extends Component
{
    public Shelf $shelf;

    public function render()
    {
        return view('livewire.book-create');
    }
}