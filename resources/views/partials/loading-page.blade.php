<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? __('Loading') }}
    </x-page-header>

    <x-page-card class="flex grow flex-col">
        <x-slot name="section" class="flex grow flex-col"></x-slot>
        <x-slot name="container" class="flex grow flex-col"></x-slot>
        <x-loading>{{ $message ?? 'Loading' }}</x-loading>
    </x-page-card>
</div>
