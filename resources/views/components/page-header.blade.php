<header class="bg-base-100 shadow">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-6 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold leading-tight">{{ $slot }}</h2>
        {{ $actions ?? '' }}
    </div>
</header>
