<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    #[Locked]
    public ?User $user;

    #[On('profile-update')]
    public function profileUpdate()
    {
        $this->user = Auth::user();
    }

    #[On('logout')]
    public function logout()
    {
        Auth::logout();

        return $this->redirect('/', navigate: true);
    }

    public function mount()
    {
        $this->user = Auth::user();
    }
}
