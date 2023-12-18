<?php

namespace App\Livewire;

use App\Actions\Shelf\DeleteShelf;
use App\Actions\Shelf\UpdateShelf;
use App\Helpers\Flash;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShelfEdit extends Component
{
    public Shelf $shelf;

    public $confirmingShelfDeletion = false;

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

    public function confirmShelfDeletion()
    {
        $this->confirmingShelfDeletion = true;
    }

    public function deleteShelf(DeleteShelf $deleteShelf, Flash $flash)
    {
        Gate::authorize('delete', $this->shelf);

        $deleteShelf->delete($this->shelf);

        $flash->danger("\"{$this->shelf->title}\" was deleted.");

        return to_route('shelves.index');
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
