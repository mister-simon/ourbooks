<?php

use App\Livewire\ShelfCreate;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShelfCreate::class)
        ->assertStatus(200);
});
