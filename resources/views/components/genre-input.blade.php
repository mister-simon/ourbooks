<?php

use App\Enums\Genre;

$randomId = join([$attributes->get('name'), Str::uuid()]);
$options = Genre::select();

?>
<x-form-group :attributes="$attributes">
    <input {{ $attributes->merge([
        'type' => 'text',
        'name' => $attributes->get('name'),
        'list' => $randomId,
    ]) }} />

    <datalist id="{{ $randomId }}">
        @foreach ($options as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </datalist>

</x-form-group>
