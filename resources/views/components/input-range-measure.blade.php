@php($steps ??= ($max - $min) / $step)

<div {{ $attributes->merge(['aria-hidden' => 'true'])->class('flex w-full justify-between items-center select-none pointer-events-none [&>span]:w-0 [&>span]:inline-flex [&>span]:justify-center [&>span]:overflow-visible') }}>
    @for ($i = 0; $i < $steps + 1; $i++)
        <span>{{ $slot->isNotEmpty() ? $slot : '|' }}</span>
    @endfor
</div>
