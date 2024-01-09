<?php

namespace App\Livewire;

use App\Actions\Shelf\CreateShelfInvite;
use App\Helpers\PrepareInput;
use App\Models\Shelf;
use App\Models\ShelfInvite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShelfInviteCreate extends Component
{
    public Shelf $shelf;

    public $confirmingInviteDeletion = false;

    public $confirmingInvite = null;

    public $state = [
        'name' => '',
        'email' => '',
    ];

    public function confirmInviteDeletion(ShelfInvite $invite)
    {
        $this->confirmingInviteDeletion = true;
        $this->confirmingInvite = $invite;
    }

    public function deleteInvite()
    {
        if ($this->confirmingInvite === null) {
            return;
        }

        Gate::authorize('delete', $this->confirmingInvite);

        $this->confirmingInvite->delete();
        $this->confirmingInvite = null;
        $this->confirmingInviteDeletion = false;
    }

    public function create(CreateShelfInvite $createShelfInvite)
    {
        Gate::authorize('create', [ShelfInvite::class, $this->shelf]);

        $this->resetErrorBag();

        $createShelfInvite->invite(
            Auth::user(),
            $this->shelf,
            PrepareInput::process($this->state)
        );

        $this->dispatch('saved');
        $this->reset('state');
    }

    public function render()
    {

        return view('livewire.shelf-invite-create')
            ->layout('layouts.app', [
                'title' => __('Shelf - :shelf', ['shelf' => $this->shelf->title]).__(' - Invite User'),
            ]);
    }
}
