<?php

use App\Http\Middleware\RequireUserName;
use function Laravel\Folio\{middleware};
use function Livewire\Volt\{computed, state, rules, on};

middleware(['auth', RequireUserName::class]);

state(['shelf' => fn() => $shelf]);
state(['books' => fn() => $this->getBooks()]);
state(['user' => fn() => Auth::user()]);

$getBooks = fn() => $this->shelf
    ->books()
    ->orderBy('author_surname')
    ->orderBy('author_forename')
    ->orderBy('series')
    ->orderBy('series_index')
    ->orderBy('title')
    ->get();

on(['shelf-user-added' => fn() => $this->shelf->load('users')]);
on(['book-created' => fn() => ($this->books = $this->getBooks())]);

?>
<x-layouts.app :title="$shelf->title">
    <livewire:header />

    <x-main>
        @volt('shelf.index')
            <div>
                <x-well>
                    <livewire:shelf-list />
                </x-well>

                <x-well>
                    <x-title>{{ $shelf->title }}</x-title>

                    <p class="pb-4">This shelf belongs to {{ $shelf->userListString() }}</p>

                    <p> Maybe add some friends below?</p>

                    <livewire:shelf-user-add :shelf="$this->shelf" />
                </x-well>

                <x-well>
                    <livewire:book-create :shelf="$shelf" />

                    <div class="mt-4">
                        @forelse ($this->books as $book)
                            <div>
                                <h2>{{ $book->title }} - {{ join(' ', $book->only('author_surname', 'author_forename')) }}</h2>
                            </div>
                        @empty
                            <p>No books yet.</p>
                        @endforelse

                    </div>
                </x-well>
            </div>
        @endvolt
    </x-main>
</x-layouts.app>
