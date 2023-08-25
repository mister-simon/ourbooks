<?php

namespace App\Livewire;

use App\Models\Shelf;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShelfShow extends Component
{
    #[Locked]
    public Shelf $shelf;

    public string $state;

    public ?string $search = null;

    #[Computed]
    public function users()
    {
        return $this->shelf
            ->users
            ->keyBy('id');
    }

    public function mount()
    {
        $this->state = $this->shelf->books()->exists()
            ? 'filter'
            : 'create';
    }

    public function render()
    {
        return view('livewire.shelf-show');
    }
}
