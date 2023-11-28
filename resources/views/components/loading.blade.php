<div
    {{ $attributes->merge([
        'class' => 'alert alert-info',
    ]) }}>
    <span class="loading"></span> {{ $slot->isEmpty() ? 'Loading' : $slot }}
</div>
