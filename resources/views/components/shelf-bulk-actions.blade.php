<div class="flex flex-row gap-4">
    <div
        class="dropdown dropdown-bottom"
        x-data="{ isOpen: false }"
        x-cloak>
        <div
            tabindex="0"
            role="button"
            class="btn btn-outline btn-xs">
            <span x-text="`{{ __('${onlySelected.length} currently selected') }} ▼`"></span>
        </div>

        <div
            class="dropdown-content z-20"
            tabindex="0">
            <div class="join join-vertical w-max bg-base-100 md:join-horizontal" x-cloak>
                <div
                    class="join-item flex items-start justify-start gap-4 rounded-b-none rounded-t-box border p-4">
                    <label class="form-control">
                        <div class="label sr-only">
                            <span class="label-text">{{ __('Rating') }}</span>
                        </div>

                        <select
                            name="rating"
                            id="rating"
                            class="select select-bordered select-sm"
                            x-model="rating">
                            @foreach (range(0, 10) as $rating)
                                <option value="{{ $rating }}">{{ $rating }}</option>
                            @endforeach
                        </select>

                        @error('rating')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <button
                        type="submit"
                        class="btn btn-sm"
                        x-bind:disabled="onlySelected.length === 0"
                        @click.prevent="onlySelected.length && $wire.rateMany(onlySelected, shelfId, rating)">{{ __('Rate') }}</button>
                </div>

                <div
                    class="join-item flex items-start justify-start gap-4 rounded-b-none rounded-t-box border p-4">
                    <label class="form-control">
                        <div class="label sr-only">
                            <span class="label-text">{{ __('Read') }}</span>
                        </div>

                        <select
                            name="read"
                            id="read"
                            class="select select-bordered select-sm"
                            x-model="read">
                            @foreach (App\Enums\ReadStatus::select() as $status => $trans)
                                <option value="{{ $status }}">{{ $trans }}</option>
                            @endforeach
                        </select>

                        @error('read')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>
                    <button
                        type="submit"
                        class="btn btn-sm"
                        x-bind:disabled="onlySelected.length === 0"
                        @click.prevent="onlySelected.length && $wire.readMany(onlySelected, shelfId, read)">{{ __('Set Read') }}</button>
                </div>
            </div>
        </div>
    </div>

    <x-action-message on="saved">{{ __('Saved.') }}</x-action-message>
</div>
