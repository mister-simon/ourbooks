<?php

use function Livewire\Volt\{state, computed};

state(['books' => fn() => $books]);

$groupedBooks = computed(fn() => $this->books->groupBy('authorSurnameChar')->map(fn($booksByChar) => $booksByChar->groupBy('authorName')));

?>

<div>
    @if ($this->books->isNotEmpty())
        <div class="relative mx-6 my-4 space-y-4">
            @foreach ($this->groupedBooks as $character => $booksByChar)
                <div class="relative space-y-4">
                    <div class="absolute right-full top-0 bg-primary-500 p-2 font-mono text-xs leading-none text-white">
                        <h2>{{ $character }}</h2>
                    </div>

                    @foreach ($booksByChar as $author => $booksByAuthor)
                        <div class="relative overflow-hidden border-t border-primary-500">
                            <div class="absolute left-6 top-3">
                                @if (trim($author))
                                    <h3 class="inline-block origin-top-left rotate-90 text-ellipsis text-xs font-bold">{{ $author }}</h3>
                                @endif
                            </div>

                            <div class="ml-4 grid grid-cols-4 gap-1 p-4">
                                @foreach ($booksByAuthor as $book)
                                    <div class="border border-neutral-400 bg-white p-4 drop-shadow">
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
