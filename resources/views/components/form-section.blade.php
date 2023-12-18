@props(['submit'])
@php($hasTitle = ($title ?? false) || ($description ?? false))

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    @if ($hasTitle)
        <x-section-title>
            <x-slot name="title">{{ $title ?? '' }}</x-slot>
            <x-slot name="description">{{ $description ?? '' }}</x-slot>
        </x-section-title>
    @endif

    <div @class([
        'mt-5 md:col-span-2 md:mt-0' => $hasTitle,
        'mt-5 md:col-span-3 md:mt-0' => !$hasTitle,
    ])>
        <form wire:submit="{{ $submit }}">
            <div class="{{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }} bg-white px-4 py-5 shadow sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>

                {{ $slot }}
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end bg-base-200 px-4 py-3 text-end shadow sm:rounded-bl-md sm:rounded-br-md sm:px-6">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
