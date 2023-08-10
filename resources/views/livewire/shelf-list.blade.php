<?php

use App\Helpers\ShelfUserSession;
use function Livewire\Volt\{state, computed};

$shelves = computed(fn() => ShelfUserSession::all());

?>

@if ($this->shelves->isNotEmpty())
    <x-well>
        <nav>
            <p class="text-sm">Your Shelves</p>

            <ul class="flex flex-wrap gap-2 py-2">
                @foreach ($this->shelves as $shelf)
                    <li>
                        <x-link href="{{ $shelf->getUrl() }}">
                            {{ $shelf->title }}
                        </x-link>
                    </li>
                @endforeach
            </ul>
        </nav>
    </x-well>
@endif
