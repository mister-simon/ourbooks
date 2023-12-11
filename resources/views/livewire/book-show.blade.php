<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? $shelf->title . ' - ' . __('Create Book') }}

        <x-slot name="actions">
            <a
                href="{{ route('shelves.book.edit', ['shelf' => $shelf, 'book' => $book]) }}"
                class="btn btn-primary ml-auto">{{ __('Edit Book') }}</a>
        </x-slot>

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('shelves.show', ['shelf' => $shelf]) }}">{{ str($shelf->title)->limit(15) }}</a></li>
                <li><a href="{{ route('shelves.book.show', ['shelf' => $shelf, 'book' => $book]) }}">{{ str($book->title)->limit(15) }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <x-page-card>
        <dl class="grid grid-flow-dense flex-wrap sm:grid-cols-2 sm:gap-2 md:grid-cols-3 md:gap-4 2xl:grid-cols-6">
            <div class="flex flex-col">
                <dt class="origin-left -translate-x-1 translate-y-1 -rotate-6 self-start text-4xl font-semibold leading-none text-accent">
                    {{ trans_choice('Author|Authors', (!empty($book->author_name) && !empty($book->co_author)) + 1) }}
                </dt>
                <dd class="-mt-4 mb-4 grow rounded-box border p-4 px-4 text-xl font-light">
                    {{ empty($book->author_name) ? __('N/A') : $book->author_name }}
                    @if ($book->co_author)
                        <br>
                        <span class="text-sm italic">({{ $book->co_author }})</span>
                    @endif
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="origin-left -translate-x-1 translate-y-1 -rotate-6 self-start text-4xl font-semibold leading-none text-accent">
                    {{ __('Edition') }}
                </dt>
                <dd class="-mt-4 mb-4 grow rounded-box border p-4 px-4 text-xl font-light">
                    {{ $book->edition }}
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="origin-left -translate-x-1 translate-y-1 -rotate-6 self-start text-4xl font-semibold leading-none text-accent">
                    {{ __('Series') }}
                </dt>
                <dd class="-mt-4 mb-4 grow rounded-box border p-4 px-4 text-xl font-light">
                    {{ empty($book->series_text) ? __('N/A') : $book->series_text }}
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="origin-left -translate-x-1 translate-y-1 -rotate-6 self-start text-4xl font-semibold leading-none text-accent">
                    {{ __('Genre') }}
                </dt>
                <dd class="-mt-4 mb-4 grow rounded-box border p-4 px-4 text-xl font-light">
                    {{ empty($book->genre) ? __('N/A') : $book->genre }}
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="origin-left -translate-x-1 translate-y-1 -rotate-6 self-start text-4xl font-semibold leading-none text-accent">
                    {{ __('Avg. Rating') }}
                </dt>
                <dd class="-mt-4 mb-4 inline-flex grow items-center justify-between rounded-box border p-4 px-4 text-xl font-light">
                    @if ($book->book_user_avg_rating)
                        {{ $book->book_user_avg_rating }} / 10
                        <x-table-rating :rating="$book->book_user_avg_rating" />
                    @else
                        {{ __('N/A') }}
                    @endif
                </dd>
            </div>

            <div class="flex flex-col">
                <dt class="origin-left -translate-x-1 translate-y-1 -rotate-6 self-start text-4xl font-semibold leading-none text-accent">
                    {{ __('Any Read') }}
                </dt>
                <dd class="-mt-4 mb-4 inline-flex grow items-center justify-between rounded-box border p-4 px-4 text-xl font-light">
                    {{ $book->was_read->trans() }}
                    <x-table-read :read="$book->was_read" />
                </dd>
            </div>
        </dl>

        <div class="flex flex-col gap-8">

            @foreach ($book->bookUsers as $bookUser)
                <div class="card-compact card overflow-hidden shadow sm:card-side">

                    @if ($profilePhotos)
                        <div class="flex items-center justify-center gap-2 bg-neutral p-4 text-neutral-content sm:flex-col">
                            <img class="rounded-full object-cover sm:w-full" src="{{ $bookUser->user->profile_photo_url }}" alt="" />
                            {{ $bookUser->user->readable }}
                        </div>
                    @endif

                    <div class="card-body">

                        <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-2">
                            <div class="">
                                <dt class="inline-block origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none">
                                    {{ __('Rating') }}
                                </dt>
                                <dd class="-mt-4 flex grow items-center gap-4 rounded-box p-4 px-4 font-light">
                                    @if ($bookUser->rating)
                                        {{ $bookUser->rating }} / 10
                                        <x-table-rating :rating="$bookUser->rating" />
                                    @else
                                        {{ __('N/A') }}
                                    @endif
                                </dd>
                            </div>

                            <div class="">
                                <dt class="inline-block origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none">
                                    {{ __('Read') }}
                                </dt>
                                <dd class="-mt-4 flex grow items-center gap-4 rounded-box p-4 px-4 font-light">
                                    {{ $bookUser->read->trans() }}
                                    <x-table-read :read="$bookUser->read" />
                                </dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="inline-block origin-left -translate-x-1 -rotate-6 text-xl font-semibold leading-none">
                                    {{ __('Comments') }}
                                </dt>
                                <dd class="-mt-4 flex grow items-center gap-4 rounded-box p-4 px-4 font-light">
                                    {{ empty($book->comments) ? __('N/A') : $book->comments }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-page-card>
</div>
