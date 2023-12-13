@props(['bookUser', 'profilePhotos' => \Laravel\Jetstream\Jetstream::managesProfilePhotos()])

<div class="card card-compact overflow-hidden shadow sm:card-side">
    @if ($profilePhotos)
        <div class="bg-neutral p-4 text-center text-neutral-content sm:w-3/12 md:w-2/12">
            <img class="mx-auto mb-2 rounded-full object-cover" src="{{ $bookUser->user->profile_photo_url }}" alt="" />
            <div>{{ $bookUser->user->readable }}</div>
        </div>
    @endif

    <div
        class="card-body shrink"
        x-data="{
            truncated: true,
            noTruncate: false,
            shouldTruncate() {
                return this.$el.scrollHeight !== this.$el.offsetHeight;
            },
            init() {
                this.$nextTick(() => this.truncated = this.shouldTruncate())
                this.$nextTick(() => this.noTruncate = this.shouldTruncate() === false)
            }
        }">
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
                <dd
                    class="prose prose-sm font-light"
                    x-cloak
                    x-ref="comment"
                    x-bind:class="{ 'max-h-40 clip-b-gradient-50 -mb-10': truncated }">
                    {!! $bookUser->comments_markdown !!}
                </dd>
            </dl>
            <button
                x-show="noTruncate === false"
                class="btn btn-ghost isolate sm:col-span-2"
                @click="truncated = !truncated"
                x-text="truncated ? '{{ __('Show more') }}' : '{{ __('Show less') }}'">
            </button>
        </div>
    </div>
</div>
