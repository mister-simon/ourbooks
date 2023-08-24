<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RequireUserName;
use App\Models\Book;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{computed, state, rules, on};
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Arr;

name('shelf');
middleware([Authenticate::class, RequireUserName::class]);
middleware([Authorize::using('view', 'shelf')]);

state(['shelf' => fn() => $shelf])->locked();
state(['state' => fn() => $this->shelf->books->isEmpty() ? 'create' : 'filter']);

$users = computed(fn() => $this->shelf->users->keyBy('id'));

on(['shelf-user-added' => fn() => $this->shelf->load('users')]);
on(['book-created' => fn() => $this->shelf->refresh()]);

?>
<x-layouts.app :title="$shelf->title">
    <x-main class="container mx-auto !items-start">
        @volt('shelf.index')
            <div class="w-full space-y-4">
                <x-card class="rounded-t-none">
                    <livewire:shelf-list />
                </x-card>

                <x-card>
                    <x-title>{{ $shelf->title }}</x-title>

                    <p class="pb-4">This shelf belongs to {{ $shelf->userListString() }}</p>

                    <p> Maybe add some friends below?</p>

                    <livewire:shelf-user-add :shelf="$this->shelf" />
                </x-card>

                <x-card>
                    <div>
                        <div class="overflow-hidden">
                            <x-button
                                wire:click="$set('state', 'create')"
                                class="{{ $this->state !== 'create' ? 'opacity-70' : '' }} rounded-b-none">
                                Create
                            </x-button>
                            <x-button
                                wire:click="$set('state', 'filter')"
                                class="{{ $this->state !== 'filter' ? 'opacity-70' : '' }} rounded-b-none">
                                Filter
                            </x-button>
                        </div>

                        <x-hr class="mt-0 border-t-4 border-primary-500" />

                        @if ($this->state === 'create')
                            <livewire:book-create :shelf="$shelf" />
                        @endif

                        @if ($this->state === 'filter')
                            <livewire:book-filter />
                        @endif
                    </div>

                    <x-hr />

                    <livewire:book-list
                        :shelf="$this->shelf" />
                </x-card>
            </div>
        @endvolt
    </x-main>
</x-layouts.app>
