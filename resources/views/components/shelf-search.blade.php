<div class="indicator w-auto">
    <x-loading-indicator
        class="border-1 badge-success badge-outline indicator-center bg-base-100"
        wire:loading.delay
        wire:target="search" />

    <label class="form-control w-full">
        <div class="label sr-only">
            <span class="label-text">{{ __('Search') }}</span>
        </div>
        <x-input
            id="search"
            type="search"
            placeholder="Search"
            class="input-primary input-sm md:input-md"
            wire:model.live.debounce="search"
            x-on:change="$dispatch('search-change');" />
    </label>

    <x-button class="sr-only">{{ __('Submit') }}</x-button>
</div>

@if ($this->search)
    <div class="flex justify-between">
        <p class="px-4">
            {{ trans_choice(':count result for search ":search".|:count results for search ":search".', $this->filteredBooksCount, ['search' => $this->search]) }}
        </p>
        <button
            class="btn btn-outline btn-primary btn-sm"
            wire:click="$set('search', '')">
            {{ __('Clear Search') }}
        </button>
    </div>
@else
    <div class="flex justify-between">
        <p class="px-4">
            {{ trans_choice(':count book on the shelf.|:count books on the shelf.', $this->filteredBooksCount) }}
        </p>
    </div>
@endif
