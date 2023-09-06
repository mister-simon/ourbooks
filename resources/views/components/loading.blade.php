<div
    {{ $attributes->merge([
        'class' => 'flex flex-row items-center justify-center gap-2 bg-slate-200/5 p-2 text-center backdrop-blur',
    ]) }}>
    @svg('heroicon-o-arrow-path', 'w-4 h-4 animate-spin') {{ $slot->isEmpty() ? 'Loading' : $slot }}
</div>
