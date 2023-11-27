<?php

use App\Livewire\ShelfInviteCreate;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShelfInviteCreate::class)
        ->assertStatus(200);
});
