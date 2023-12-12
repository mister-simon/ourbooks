@props(['bookUser', 'profilePhotos' => \Laravel\Jetstream\Jetstream::managesProfilePhotos()])

<div class="card card-compact overflow-hidden shadow sm:card-side">
    @if ($profilePhotos)
        <div class="flex flex-wrap items-center justify-start gap-2 bg-neutral p-4 text-center text-neutral-content sm:w-3/12 sm:justify-evenly md:w-2/12">
            <img class="rounded-full object-cover" src="{{ $bookUser->user->profile_photo_url }}" alt="" />
            <div>{{ $bookUser->user->readable }}</div>
        </div>
    @endif

    <div class="card-body">
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-2">
            <dl>
                <dt class="inline-block origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none">
                    {{ __('Rating') }}
                </dt>
                <dd class="-mt-4 flex grow items-center gap-4 rounded-box p-4 px-4 font-light">
                    @if ($bookUser->rating)
                        <x-table-rating
                            :rating="$bookUser->rating" />
                    @else
                        {{ __('N/A') }}
                    @endif
                </dd>
            </dl>

            <dl>
                <dt class="inline-block origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none">
                    {{ __('Read') }}
                </dt>
                <dd class="-mt-4 flex grow items-center gap-4 rounded-box p-4 px-4 font-light">
                    <x-table-read
                        :read="$bookUser->read" />
                    {{ $bookUser->read->trans() }}
                </dd>
            </dl>

            <dl class="sm:col-span-2">
                <dt class="inline-block origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none">
                    {{ __('Comments') }}
                </dt>
                <dd class="-mt-4 flex grow items-center gap-4 rounded-box p-4 px-4 font-light">
                    {{ empty($book->comments) ? __('N/A') : $book->comments }}
                </dd>
            </dl>
        </div>
    </div>
</div>
