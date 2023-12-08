@php($section ??= new \Illuminate\View\ComponentSlot())
@php($container ??= new \Illuminate\View\ComponentSlot())
<section {{ $section->attributes->class('grow bg-gray-100 py-12') }}>
    <div {{ $container->attributes->class('grid sm:px-6 lg:px-8') }}>
        <div {{ $attributes->class('card bg-base-100 shadow-xl') }}>
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
