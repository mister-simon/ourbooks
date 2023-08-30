<?php

namespace App\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BookSearch extends Component
{
    #[
        Modelable,
        Rule(['nullable', 'string'])
    ]
    public ?string $search;

    #[On('book-search-set')]
    public function setSearch($search)
    {
        $this->validate();

        $this->search = $search;

        $this->dispatch('book-search', search: $this->search);
    }

    #[Renderless]
    public function updatedSearch()
    {
        $this->dispatch('book-search-set', search: $this->search)
            ->self();
    }

    #[Renderless]
    public function doSearch()
    {
        $this->dispatch('book-search-set', search: $this->search)
            ->self();
    }
}
