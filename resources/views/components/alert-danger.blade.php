<div
    {{ $attributes->merge([
        'class' => 'mb-4 rounded-lg bg-secondary-100 px-6 py-5 text-base text-danger-700',
        'role' => 'alert',
    ]) }}>
    {{ $slot }}
</div>
