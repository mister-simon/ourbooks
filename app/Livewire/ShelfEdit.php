<?php

namespace App\Livewire;

use App\Actions\Shelf\UpdateShelf;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShelfEdit extends Component
{
    public Shelf $shelf;

    public $state = [
        'title' => '',
    ];

    public function mount()
    {
        $this->state['title'] = $this->shelf->title;
    }

    public function create(UpdateShelf $updateShelf)
    {
        Gate::authorize('update', [$this->shelf]);

        $this->resetErrorBag();

        $updateShelf->update(
            Auth::user(),
            $this->shelf,
            $this->state
        );

        $this->dispatch('saved');

        return redirect()
            ->route('shelves.show', ['shelf' => $this->shelf]);
    }

    public function render()
    {
        $title = __('Shelf Edit - :shelf', ['shelf' => $this->shelf->title]);

        return view('livewire.shelf-create', [
            'title' => $title,
            'subtitle' => __('Edit Shelf'),
        ])
            ->layout('layouts.app', [
                'title' => $title,
            ]);
    }
}
