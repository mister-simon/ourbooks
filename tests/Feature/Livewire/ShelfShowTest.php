<?php

use App\Livewire\ShelfShow;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShelfShow::class)
        ->assertStatus(200);
});
