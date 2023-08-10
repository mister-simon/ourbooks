<div class="self-centre mb-4 flex flex-col">
    <label for="title" class="block">{{ $label ??str($attributes->get('name'))->replace('_', ' ')->title() }}</label>

    {{ $slot }}

    @error($attributes->get('name'))
        <p class="text-sm">{{ $message }}</p>
    @enderror
</div>
