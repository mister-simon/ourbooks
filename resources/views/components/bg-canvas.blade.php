{{-- <div class="fixed inset-0 -z-40 h-full w-full bg-gradient-radial from-white/50 to-white/75 mix-blend-lighten dark:mix-blend-darken dark:invert"></div> --}}
<canvas {{ $attributes->merge([
    'class' => 'fixed inset-0 -z-50 h-full w-full opacity-70 blur-lg motion-reduce:hidden dark:opacity-100',
    'id' => 'bg-canvas',
]) }}></canvas>
