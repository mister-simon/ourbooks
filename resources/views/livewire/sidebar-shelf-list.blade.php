<?php

use App\Helpers\ShelfUserSession;
use function Livewire\Volt\{state, computed};

state(['user' => fn() => Auth::user()])->locked();
state(['shelves' => fn() => $this->user ? $this->user->shelves : collect()])->locked();

?>

<x-menu title="Your Shelves">
    @if ($this->shelves->isNotEmpty())
        @foreach ($this->shelves as $shelf)
            <x-menu-item
                :title="$shelf->title"
                icon="s-view-columns"
                :link="route('shelf', ['shelf' => $shelf])" />
        @endforeach
    @else
        <x-menu-item
            title="No Shelves Yet, Add One!"
            icon="s-bookmark-slash"
            :link="route('home')" />
    @endif
</x-menu>
