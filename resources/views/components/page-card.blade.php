<section class="grow bg-gray-100 py-12">
    <div class="container mx-auto grid sm:px-6 lg:px-8">
        <div {{ $attributes->class('card bg-base-100 shadow-xl') }}>
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
