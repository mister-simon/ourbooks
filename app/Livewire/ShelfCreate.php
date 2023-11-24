<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app', [
    'title' => 'Hello!',
])]
class ShelfCreate extends Component
{
    public function render()
    {
        return view('livewire.shelf-create');
    }
}
