<x-form-group :attributes="$attributes">
    <input {{ $attributes->merge([
        'type' => 'number',
        'name' => $attributes->get('name'),
        'id' => $attributes->get('id') ?? $attributes->get('name'),
    ]) }} />
</x-form-group>
