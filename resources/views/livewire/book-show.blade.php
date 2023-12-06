<div class="flex grow flex-col">
    <x-page-header>
        {{ $title ?? $shelf->title . ' - ' . __('Create Book') }}

        <x-slot name="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('shelves.show', ['shelf' => $shelf]) }}">{{ str($shelf->title)->limit(15) }}</a></li>
                <li><a href="{{ route('shelves.book.show', ['shelf' => $shelf, 'book' => $book]) }}">{{ str($book->title)->limit(15) }}</a></li>
            </ol>
        </x-slot>
    </x-page-header>

    <x-page-card>

    </x-page-card>
</div>
