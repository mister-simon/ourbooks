<?php

namespace App\Livewire;

use App\Helpers\ShelfUserSession;
use Livewire\Component;

class ShelfList extends Component
{
    public function render()
    {
        return view('livewire.shelf-list', [
            'shelves' => ShelfUserSession::all(),
        ]);
    }
}
