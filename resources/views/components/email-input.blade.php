<x-form-group :attributes="$attributes">
    <input {{ $attributes->merge([
        'type' => 'email',
        'name' => $attributes->get('name'),
        'id' => $attributes->get('id') ?? $attributes->get('name'),
        'placeholder' =>
            $label ??
            str($attributes->get('name'))->replace('_', ' ')->title(),
        'class' => 'peer block min-h-[auto] w-full rounded border-neutral-200 bg-transparent px-3 py-[0.32rem] leading-[1.6] transition-all duration-200 ease-linear',
    ]) }} />
</x-form-group>
