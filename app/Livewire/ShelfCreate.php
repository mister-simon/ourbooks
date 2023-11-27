<?php

namespace App\Livewire;

use App\Actions\Shelf\CreateShelf;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[
    Layout('layouts.app', [
        'title' => 'Hello!',
    ])
]
class ShelfCreate extends Component
{
    public $state = [
        'title' => '',
    ];

    public function create(CreateShelf $createShelf)
    {
        Gate::authorize('create', Shelf::class);

        $this->resetErrorBag();

        $shelf = $createShelf->create(
            Auth::user(),
            $this->state
        );

        $this->dispatch('saved');

        if ($shelf) {
            return redirect()
                ->route('shelves.show', ['shelf' => $shelf]);
        }
    }

    public function render()
    {
        return view('livewire.shelf-create');
    }
}
