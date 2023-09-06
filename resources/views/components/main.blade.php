<main {{ $attributes->merge([
    'class' => 'relative mx-auto my-auto flex w-full flex-1 grow-0 justify-center bg-center px-2 sm:container sm:items-center',
    'id' => 'content',
]) }}>
    {{ $slot }}
</main>
