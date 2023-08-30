<div class="{{ $attributes->get('wrapperClasses') }} relative my-3 flex flex-col">
    {{ $slot }}

    @unless ($attributes->has('hide-label'))
        <label
            for="{{ $attributes->get('id') ?? $attributes->get('name') }}"
            class="-order-1 text-neutral-500 transition-all duration-200 ease-out peer-focus:text-primary motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary-400">
            {{ $label ??str($attributes->get('name'))->replace('_', ' ')->title() }}
        </label>
    @endunless

    @error($attributes->get('name'))
        <p class="text-sm">{{ $message }}</p>
    @enderror
</div>
