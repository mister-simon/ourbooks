<div
    {{ $attributes->merge([
        'class' => 'mb-4 rounded-lg bg-primary-100 px-6 py-5 text-base text-primary-600 dark:text-primary-100 dark:bg-primary-600',
        'role' => 'alert',
    ]) }}>
    {{ $slot }}
</div>
