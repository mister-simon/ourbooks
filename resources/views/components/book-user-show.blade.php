@props(['bookUser', 'profilePhotos' => \Laravel\Jetstream\Jetstream::managesProfilePhotos()])

<div class="card card-compact overflow-hidden shadow sm:card-side">
    @if ($profilePhotos)
        <div class="flex flex-wrap items-center justify-start gap-2 bg-neutral p-4 text-center text-neutral-content sm:w-3/12 sm:justify-evenly md:w-2/12">
            <img class="rounded-full object-cover" src="{{ $bookUser->user->profile_photo_url }}" alt="" />
            <div>{{ $bookUser->user->readable }}</div>
        </div>
    @endif

    <div class="card-body shrink">
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-2">
            <dl>
                <dt class="text-xl font-semibold">
                    {{ __('Rating') }}
                </dt>
                <dd class="flex grow items-center gap-4 font-light">
                    @if ($bookUser->rating)
                        <x-table-rating
                            :rating="$bookUser->rating" />
                    @else
                        {{ __('N/A') }}
                    @endif
                </dd>
            </dl>

            <dl>
                <dt class="text-xl font-semibold">
                    {{ __('Read') }}
                </dt>
                <dd class="flex grow items-center gap-4 font-light">
                    <x-table-read
                        :read="$bookUser->read_or_unknown" />
                    {{ $bookUser->read_or_unknown->trans() }}
                </dd>
            </dl>

            <dl class="sm:col-span-2">
                <dt class="text-xl font-semibold">
                    {{ __('Comments') }}
                </dt>
                <dd class="truncate font-light">{!! empty(trim($bookUser->comments))
                    ? __('N/A')
                    : str(e($bookUser->comments))->squish()->replace("\n", '<br>') !!}</dd>
            </dl>
        </div>
    </div>
</div>
