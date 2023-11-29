<div
    {{ $attributes->merge([
        'class' => 'alert indicator w-auto',
    ]) }}>
    <x-loading-indicator class="indicator-center border-4 text-base-300" />
    {{ $slot->isEmpty() ? 'Loading' : $slot }}
</div>
