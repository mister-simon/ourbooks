<div class="fixed inset-0 -z-40 h-full w-full bg-gradient-radial from-white/75 to-white/50 mix-blend-lighten dark:to-white/0 dark:mix-blend-darken dark:invert"></div>
<canvas {{ $attributes->merge([
    'class' => 'fixed inset-0 -z-50 h-full w-full opacity-70 blur dark:blur-lg motion-reduce:hidden dark:opacity-100',
    'id' => 'bg-canvas',
]) }}></canvas>
