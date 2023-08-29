<?php

namespace App\Livewire;

use App\Models\Shelf;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class BookList extends Component
{
    #[Locked]
    public Shelf $shelf;

    #[Url]
    public ?string $layout = 'shelf';

    public ?string $search = null;

    public array $layouts = [
        'shelf' => 'book-list-shelf',
        'table' => 'book-list-table',
    ];

    public array $icons = [
        'shelf' => 'heroicon-o-view-columns',
        'table' => 'heroicon-o-table-cells',
    ];

    #[On('book-search')]
    public function searchUpdated($search)
    {
        $this->search = $search ?? null;
    }
}
