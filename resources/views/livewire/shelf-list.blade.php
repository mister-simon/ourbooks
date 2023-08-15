<?php

use App\Helpers\ShelfUserSession;
use function Livewire\Volt\{state, computed};

state(['user' => fn() => Auth::user()]);
state(['shelves' => fn() => $this->user ? $this->user->shelves : collect([])]);

?>

<nav>
    @if ($this->shelves->isNotEmpty())
        <x-subtitle>Your Shelves</x-subtitle>

        <ul class="flex flex-wrap gap-2 py-2">
            @foreach ($this->shelves as $shelf)
                <li>
                    <x-link href="{{ route('shelf', ['shelf' => $shelf]) }}">
                        {{ $shelf->title }}
                    </x-link>
                </li>
            @endforeach
        </ul>
    @else
        <x-subtitle>No Shelves Yet, Add One!</x-subtitle>
    @endif
</nav>
