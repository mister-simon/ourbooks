@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-error']) }}>{{ $message }}</p>
@enderror
