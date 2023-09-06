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

    @if ($layout === 'shelf')
        <livewire:book-list-shelf
            lazy="on-load"
            :shelf="$this->shelf"
            :search="$this->search" />
    @else
        <livewire:book-list-table
            lazy="on-load"
            :shelf="$this->shelf"
            :search="$this->search" />
    @endif
</div>
