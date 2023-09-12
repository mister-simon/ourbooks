<?php

namespace App\Livewire\Traits;

use App\Enums\ReadStatus;
use Livewire\Attributes\Computed;

trait HasReadStatus
{
    #[Computed(persist: true)]
    public function readStatusSelect()
    {
        return ReadStatus::select();
    }
}
