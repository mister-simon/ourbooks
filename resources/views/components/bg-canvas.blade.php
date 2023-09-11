@persist('bg-canvas')
    <div class="fixed inset-0 -z-40 h-full w-full bg-gradient-radial from-base-100 to-base-100/80 mix-blend-lighten dark:from-base-100 dark:to-base-100/60 dark:mix-blend-darken"></div>
    <canvas {{ $attributes->merge([
        'class' => 'fixed inset-0 -z-50 h-full w-full opacity-70 blur dark:blur-lg motion-reduce:hidden dark:opacity-100',
        'id' => 'bg-canvas',
    ]) }}></canvas>
@endpersist
