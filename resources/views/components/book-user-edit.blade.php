@props(['bookUser', 'profilePhotos' => \Laravel\Jetstream\Jetstream::managesProfilePhotos()])

<div class="card card-compact overflow-hidden shadow sm:card-side">
    @if ($profilePhotos)
        <div class="flex flex-wrap items-center justify-start gap-2 bg-neutral p-4 text-center text-neutral-content sm:w-3/12 sm:justify-evenly md:w-2/12">
            <img class="rounded-full object-cover" src="{{ $bookUser->user->profile_photo_url }}" alt="" />
            <div>{{ $bookUser->user->readable }}</div>
        </div>
    @endif

    <div class="card-body !p-0">
        <x-form-section submit="editBookUser" x-data="{ rating: {{ $this->state['rating'] }} }">
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-3">
                    <x-label
                        for="rating"
                        value="{{ __('Rating') }}"
                        class="origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none" />
                    <div class="flex flex-row gap-4">
                        <div class="grow">
                            <input
                                id="rating"
                                type="range"
                                min="0"
                                max="10"
                                step="0.5"
                                class="range"
                                wire:model="state.rating"
                                x-model="rating" />
                            <x-input-range-measure
                                :min="0"
                                :max="10"
                                :step="0.5"
                                class="-mt-4 px-3 text-xl font-bold [&>span:nth-child(1)]:text-error [&>span:nth-child(11)]:text-warning [&>span:nth-child(21)]:text-success [&>span:nth-child(even)]:opacity-10" />
                        </div>
                        <x-table-rating
                            :rating="$this->state['rating']"
                            x-text="rating" x-bind:style="{ '--rating-pos': `${(rating) * 10}%` }" />
                    </div>
                    <x-input-error
                        for="rating"
                        class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label
                        for="read"
                        value="{{ __('Read') }}"
                        class="origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none" />
                    <select
                        name="read"
                        id="read"
                        class="select select-bordered w-full"
                        wire:model="state.read">
                        @foreach (App\Enums\ReadStatus::select() as $status => $trans)
                            <option value="{{ $status }}">{{ $trans }}</option>
                        @endforeach
                    </select>
                    <x-input-error
                        for="read"
                        class="mt-2" />
                </div>

                <div class="col-span-6">
                    <x-label
                        for="comments"
                        value="{{ __('Comments') }}"
                        class="origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none" />

                    <textarea
                        name="comments"
                        id="comments"
                        class="textarea textarea-bordered w-full"
                        wire:model="state.comments">
                    </textarea>
                    <x-input-error
                        for="comments"
                        class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Saved.') }}
                </x-action-message>

                <x-button>
                    {{ __('Save') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>
