<div class="w-full space-y-4">
    <x-card class="rounded-t-none border-t-0">
        <livewire:shelf-list />
    </x-card>

    <div class="sm:px-8">
        <x-card class="mx-auto -mt-2 translate-y-2 sm:-mt-8 sm:translate-y-8 md:max-w-screen-md">
            <x-title>{{ $shelf->title }}</x-title>

            <p class="pb-4">This shelf belongs to {{ $shelf->userListString() }}</p>

            <livewire:shelf-user-add :shelf="$this->shelf" />
        </x-card>
    </div>

    <x-card>
        <div>
            <div class="overflow-hidden">
                <x-button
                    wire:click="$set('state', 'create')"
                    class="{{ $this->state !== 'create' ? 'opacity-70' : '' }} rounded-b-none">
                    Create
                </x-button>
                <x-button
                    wire:click="$set('state', 'filter')"
                    class="{{ $this->state !== 'filter' ? 'opacity-70' : '' }} rounded-b-none">
                    Filter
                </x-button>
            </div>

            <x-hr class="border-primary-500 mt-0 border-t-4" />

            @if ($this->state === 'create')
                <livewire:book-create :shelf="$this->shelf" />
            @endif

            @if ($this->state === 'filter')
                <livewire:book-search wire:model="search" />
            @endif
        </div>

        {{ $this->search }}

        <x-hr />

        <livewire:book-list
            :shelf="$this->shelf"
            :search="$this->search" />
    </x-card>
</div>
