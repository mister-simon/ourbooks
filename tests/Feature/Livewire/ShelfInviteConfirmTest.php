<?php

use App\Livewire\ShelfInviteConfirm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShelfInviteConfirm::class)
        ->assertStatus(200);
});
