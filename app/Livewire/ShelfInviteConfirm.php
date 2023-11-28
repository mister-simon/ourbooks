<?php

namespace App\Livewire;

use App\Models\Shelf;
use App\Models\ShelfInvite;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShelfInviteConfirm extends Component
{
    public ShelfInvite $invite;

    public Shelf $shelf;

    public function mount()
    {
        $this->shelf = $this->invite->shelf;
    }

    public function submit($type)
    {
        if ($type === 'confirm') {
            return $this->confirm();
        }

        return $this->delete();
    }

    protected function confirm()
    {
        Gate::authorize('confirm', $this->invite);

        $this->invite->confirm();
        $this->invite->delete();

        $this->dispatch('saved');

        return to_route('shelves.show', ['shelf' => $this->shelf->id]);
    }

    protected function delete()
    {
        Gate::authorize('delete', $this->invite);

        $this->invite->delete();
        $this->dispatch('saved');

        return to_route('shelves.index');
    }

    public function render()
    {
        return view('livewire.shelf-invite-confirm')
            ->layout('layouts.app', [
                'title' => __('Shelf - :shelf', ['shelf' => $this->shelf->title]).__(' - Confirm Invitation'),
            ]);
    }
}
