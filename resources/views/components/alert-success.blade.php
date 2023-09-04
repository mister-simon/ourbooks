<div
    {{ $attributes->merge([
        'class' => 'mb-4 rounded-lg bg-secondary-100 px-6 py-5 text-base text-success-800 dark:text-secondary-100 dark:bg-success-800',
        'role' => 'alert',
    ]) }}>
    {{ $slot }}
</div>
