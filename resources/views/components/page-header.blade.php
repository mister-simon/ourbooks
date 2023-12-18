@php($breadcrumbs ??= new \Illuminate\View\ComponentSlot())
<header class="relative bg-base-100 drop-shadow-sm">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-4 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4">
            <h2 class="text-xl font-semibold leading-tight">{{ $slot }}</h2>
            @isset($subtitle)
                <div>{{ $subtitle }}</div>
            @endisset
        </div>
        {{ $actions ?? '' }}
    </div>

    @if ($breadcrumbs->isNotEmpty())
        <div class="container absolute inset-x-0 top-full mx-auto">
            <nav {{ $breadcrumbs->attributes->class('breadcrumbs rounded-b-box bg-base-100 mx-4 sm:mx-6 lg:mx-8 px-4 pt-0 w-max text-sm')->merge(['aria-label' => 'Breadcrumb']) }}>
                {{ $breadcrumbs }}
            </nav>
        </div>
    @endif
</header>
