@props(['mergeOptions' => []])
<?php

use App\Enums\Genre;

$randomId = join([$attributes->get('name'), Str::uuid()]);
$options = Genre::select($mergeOptions);

?>
@php($wrapper ??= new \Illuminate\View\ComponentSlot())
<div {{ $wrapper->attributes }}>
    <input {{ $attributes->merge([
        'type' => 'text',
        'name' => $attributes->get('name'),
        'id' => $attributes->get('id') ?? $attributes->get('name'),
        'placeholder' =>
            $label ??
            str($attributes->get('name'))->replace('_', ' ')->title(),
        'class' => 'input input-bordered',
        'list' => $randomId,
    ]) }} />

    <datalist id="{{ $randomId }}">
        @foreach ($options as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </datalist>
</div>
