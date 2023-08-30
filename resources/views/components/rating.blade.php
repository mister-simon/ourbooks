@props([
    'value' => 0,
    'max' => 10,
])
@if ($value !== null)
    <div {{ $attributes->merge([
        'class' => 'flex flex-row',
    ]) }}>
        @for ($i = 0; $i < round($value); $i++)
            @svg('heroicon-s-star', 'w-3 h-3')
        @endfor
        @for ($i = 0; $i < $max - round($value); $i++)
            @svg('heroicon-o-star', 'w-3 h-3 opacity-50')
        @endfor
    </div>
@endif
