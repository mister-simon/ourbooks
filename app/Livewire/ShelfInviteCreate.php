<?php

namespace App\Livewire;

use App\Actions\Shelf\CreateShelfInvite;
use App\Models\Shelf;
use App\Models\ShelfInvite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShelfInviteCreate extends Component
{
    public Shelf $shelf;

    public $state = [
        'email' => '',
    ];

    public function create(CreateShelfInvite $createShelfInvite)
    {
        Gate::authorize('create', [ShelfInvite::class, $this->shelf]);

        $this->resetErrorBag();

        $createShelfInvite->invite(
            Auth::user(),
            $this->shelf,
            $this->state
        );

        $this->dispatch('saved');
        $this->reset('state');
    }

    public function render()
    {
        return view('livewire.shelf-invite-create');
    }
}
