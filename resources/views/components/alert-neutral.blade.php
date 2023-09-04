<div
    {{ $attributes->merge([
        'class' => 'mb-4 rounded-lg bg-secondary-100 px-6 py-5 text-base text-neutral-600 dark:text-secondary-100 dark:bg-neutral-600',
        'role' => 'alert',
    ]) }}>
    {{ $slot }}
</div>
