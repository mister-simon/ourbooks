@if ($shelves->isNotEmpty())
    <x-well>
        <p class="text-sm">Your Shelves</p>

        <ul class="flex gap-2 py-2">
            @foreach ($shelves as $shelf)
                <li>
                    <x-link href="{{ $shelf->getUrl() }}" wire:navigate>
                        {{ $shelf->title }}
                    </x-link>
                </li>
            @endforeach
        </ul>
    </x-well>
@endif
