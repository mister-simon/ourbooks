<?php

namespace App\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BookSearch extends Component
{
    #[Modelable, Rule(['nullable', 'string'])]
    public ?string $search = null;

    #[On('book-search-set')]
    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSearch()
    {
        $this->dispatch('book-search', search: $this->search);
    }

    public function render()
    {
        return view('livewire.book-search');
    }
}
