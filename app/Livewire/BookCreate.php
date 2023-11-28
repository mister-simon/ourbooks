<?php

namespace App\Livewire;

use App\Models\Shelf;
use Livewire\Component;

class BookCreate extends Component
{
    public Shelf $shelf;

    public function render()
    {
        return view('livewire.book-create')
            ->layout('layouts.app', [
                'title' => __('Shelf - :shelf', ['shelf' => $this->shelf->title]).__(' - Create Book'),
            ]);
    }
}
