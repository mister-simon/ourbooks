<?php

use App\Livewire\BookCreate;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(BookCreate::class)
        ->assertStatus(200);
});
