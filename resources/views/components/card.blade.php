<div
    {{ $attributes->merge([
        'class' => 'block w-full rounded-lg bg-white text-left shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700',
    ]) }}>
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
