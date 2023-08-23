<?php

use function Livewire\Volt\{state, computed};

state(['books' => fn() => $books])->locked();

$groupedBooks = computed(fn() => $this->books->groupBy('authorSurnameChar')->map(fn($booksByChar) => $booksByChar->groupBy('authorName')));

?>

<div>
    @if ($this->books->isNotEmpty())
        <div class="relative mx-6 my-4 space-y-8">
            @foreach ($this->groupedBooks as $character => $booksByChar)
                <div class="relative space-y-8">
                    <div class="absolute right-full top-0 bg-primary-800 p-2 font-mono text-xs leading-none text-white">
                        <h2>{{ $character }}</h2>
                    </div>

                    @foreach ($booksByChar as $author => $booksByAuthor)
                        <div class="border-l border-t border-primary-800">
                            @if (trim($author))
                                <h3 class="bg-primary-500 py-3 pl-6 font-bold text-white">{{ $author }}</h3>
                            @endif

                            <div class="mt-4 space-y-4 px-6">
                                @foreach ($booksByAuthor as $book)
                                    <div>
                                        @if ($book->co_author)
                                            <span class="text-xs"> With {{ $book->co_author }}</span>
                                        @endif
                                        <h4 class="font-semibold">
                                            {{ $book->title }}
                                        </h4>

                                        <div class="text-xs">
                                            @foreach ($book->only('genre', 'series_text', 'edition') as $attribute => $value)
                                                <p>{{ str($attribute)->replace('_', ' ')->title() }}: {{ $value }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <p>No books yet.</p>
    @endif
</div>
