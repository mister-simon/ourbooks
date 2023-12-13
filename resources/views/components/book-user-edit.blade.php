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
                <div class="col-span-6 flex flex-col sm:col-span-3">
                    <x-label
                        for="rating"
                        value="{{ __('Rating') }}"
                        class="mb-auto text-xl font-semibold" />
                    <div class="my-auto flex flex-row items-center gap-4">
                        <div class="relative flex grow items-center">
                            <input
                                id="rating"
                                type="range"
                                min="0"
                                max="10"
                                step="0.5"
                                class="bg-rating range relative z-[1]"
                                wire:model="state.rating"
                                x-model="rating" />
                            <x-input-range-measure
                                :min="0"
                                :max="10"
                                :step="0.5"
                                class="absolute top-full -translate-y-1 px-3 font-bold leading-none [&>span:nth-child(even)]:opacity-10" />
                        </div>
                        <x-table-rating
                            :rating="$this->state['rating']"
                            x-text="rating"
                            x-bind:style="{ '--rating-pos': `${(rating) * 10}%` }" />
                    </div>
                    <x-input-error
                        for="rating"
                        class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label
                        for="read"
                        value="{{ __('Read') }}"
                        class="text-xl font-semibold" />
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
                        class="text-xl font-semibold" />

                    <textarea
                        name="comments"
                        id="comments"
                        class="textarea textarea-bordered w-full"
                        wire:model="state.comments"
                        x-data="{
                            resize() {
                                $el.style.height = 0;
                                $el.style.height = `${Math.max(100, $el.scrollHeight)}px`;
                            }
                        }"
                        x-init="resize"
                        @input="resize"
                        @saved="resize">
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
