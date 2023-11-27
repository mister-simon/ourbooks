<header class="bg-base-100 shadow">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-4 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4">
            <h2 class="text-xl font-semibold leading-tight">{{ $slot }}</h2>
            @isset($subtitle)
                <div>{{ $subtitle }}</div>
            @endisset
        </div>
        {{ $actions ?? '' }}
    </div>
</header>
