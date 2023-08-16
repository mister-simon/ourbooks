<div class="relative flex min-h-screen justify-center bg-gray-100 bg-center sm:items-center">
    <main {{ $attributes->merge(['class' => 'px-4 pb-8']) }}>
        {{ $slot }}
    </main>
</div>
