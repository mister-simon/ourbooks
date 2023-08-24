<?php

use function Livewire\Volt\{state, updating};

state([
    'layouts' => [
        // 'list' => 'book-list-list',
        // 'grid' => 'book-list-grid',
        'shelf' => 'book-list-shelf',
        'table' => 'book-list-table',
    ],
    'icons' => [
        // 'list' => 'heroicon-o-list-bullet',
        // 'grid' => 'heroicon-o-squares-2x2',
        'shelf' => 'heroicon-o-view-columns',
        'table' => 'heroicon-o-table-cells',
    ],
]);

state(['shelf' => fn() => $shelf])->locked();
state(['layout']);

?>

<div>
    <div class="mb-8">
        @foreach ($this->icons as $name => $svgComponent)
            <x-button
                wire:click="$set('layout', '{{ $name }}')"
                class="inline-flex flex-row items-center gap-2">
                @svg($svgComponent, 'w-4 h-4') {{ $name }}
            </x-button>
        @endforeach
    </div>

    @if ($layout === 'list')
        <livewire:book-list-list
            :shelf="$this->shelf" />
    @elseif ($layout === 'grid')
        <livewire:book-list-grid
            :shelf="$this->shelf" />
    @elseif ($layout === 'shelf')
        <livewire:book-list-shelf
            :shelf="$this->shelf" />
    @else
        <livewire:book-list-table
            :shelf="$this->shelf" />
    @endif
</div>
