<?php

namespace App\Livewire;

use App\Livewire\Traits\UpdatesBook;
use App\Livewire\Traits\UpdatesBookUser;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BookListShelfBook extends Component
{
    use UpdatesBook, UpdatesBookUser;

    protected array $colors = [
        'border-slate-500   bg-slate-300    dark:border-slate-600   dark:bg-slate-600',
        'border-slate-400   bg-slate-100    dark:border-slate-900   dark:bg-slate-900',
        'border-zinc-400    bg-zinc-200     dark:border-zinc-500    dark:bg-zinc-500',
        'border-neutral-300 bg-neutral-200  dark:border-neutral-600 dark:bg-neutral-600',
        'border-neutral-400 bg-neutral-300  dark:border-neutral-800 dark:bg-neutral-800',
        'border-orange-300  bg-orange-200   dark:border-orange-800  dark:bg-orange-800',
        'border-green-500   bg-green-200    dark:border-green-800   dark:bg-green-800',
        'border-sky-300     bg-sky-200      dark:border-sky-800     dark:bg-sky-800',
        'border-rose-300    bg-rose-200     dark:border-rose-800    dark:bg-rose-800',
        'border-teal-200    bg-teal-100     dark:border-teal-800    dark:bg-teal-800',
        'border-teal-300    bg-teal-200     dark:border-teal-900    dark:bg-teal-900',
        'border-green-300   bg-green-200    dark:border-green-900   dark:bg-green-900',
    ];

    #[Computed]
    public function colorIndex()
    {
        $length = count($this->colors);

        return $this->book->integer_hash % $length;
    }

    #[Computed]
    public function color()
    {
        return $this->colors[$this->colorIndex];
    }
}
