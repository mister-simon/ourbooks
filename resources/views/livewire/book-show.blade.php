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
        <dl class="grid grid-flow-dense flex-wrap gap-2 sm:grid-cols-2 md:grid-cols-3 md:gap-4 2xl:grid-cols-6">
            <div class="flex flex-col rounded-box border p-4">
                <dt class="self-start text-xl font-light">
                    {{ trans_choice('Author|Authors', (!empty($book->author_name) && !empty($book->co_author)) + 1) }}
                </dt>
                <dd class="text-xl font-semibold">
                    {{ empty($book->author_name) ? __('N/A') : $book->author_name }}
                    @if ($book->co_author)
                        <br>
                        <span class="text-sm italic">({{ $book->co_author }})</span>
                    @endif
                </dd>
            </div>

            <div class="flex flex-col rounded-box border p-4">
                <dt class="self-start text-xl font-light">
                    {{ __('Edition') }}
                </dt>
                <dd class="text-xl font-semibold">
                    {{ $book->edition }}
                </dd>
            </div>

            <div class="flex flex-col rounded-box border p-4">
                <dt class="self-start text-xl font-light">
                    {{ __('Series') }}
                </dt>
                <dd class="text-xl font-semibold">
                    {{ empty($book->series_text) ? __('N/A') : $book->series_text }}
                </dd>
            </div>

            <div class="flex flex-col rounded-box border p-4">
                <dt class="self-start text-xl font-light">
                    {{ __('Genre') }}
                </dt>
                <dd class="text-xl font-semibold">
                    {{ empty($book->genre) ? __('N/A') : $book->genre }}
                </dd>
            </div>

            <div class="flex flex-col rounded-box border p-4">
                <dt class="self-start text-xl font-light">
                    {{ __('Avg. Rating') }}
                </dt>
                <dd class="inline-flex items-center justify-between text-xl font-semibold">
                    @if ($book->book_user_avg_rating)
                        <x-table-rating :rating="$book->book_user_avg_rating" />
                    @else
                        {{ __('N/A') }}
                    @endif
                </dd>
            </div>

            <div class="flex flex-col rounded-box border p-4">
                <dt class="self-start text-xl font-light">
                    {{ __('Any Read') }}
                </dt>
                <dd class="inline-flex items-center justify-start gap-2 text-xl font-semibold">
                    <x-table-read :read="$book->was_read" />
                    {{ $book->was_read->trans() }}
                </dd>
            </div>
        </dl>

        <div class="mt-4 flex flex-col gap-8">
            <x-book-user-edit :book-user="$this->bookUser" />

            <x-section-border>{{ __('Other Users') }}</x-section-border>

            @foreach ($book->book_users_with_missing as $bookUser)
                @if ($bookUser->user()->isNot(Auth::user()))
                    <x-book-user-show :book-user="$bookUser" />
                @endif
            @endforeach
        </div>
    </x-page-card>
</div>
