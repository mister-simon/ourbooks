<main {{ $attributes->merge([
    'class' => 'relative flex flex-1 justify-center bg-center sm:items-center',
    'id' => 'content',
]) }}>
    {{ $slot }}
</main>
