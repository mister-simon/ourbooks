<div
    {{ $attributes->merge([
        'class' => 'mb-4 rounded-lg bg-neutral-800 px-6 py-5 text-base text-neutral-50 dark:bg-neutral-900',
        'role' => 'alert',
    ]) }}>
    {{ $slot }}
</div>
