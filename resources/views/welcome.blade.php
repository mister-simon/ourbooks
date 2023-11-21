<x-guest-layout>
    @livewire('navigation-menu')

    <div class="flex grow flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <div class="prose mt-6 overflow-hidden px-6 py-4 shadow-md sm:rounded-lg">
            <div class="flex justify-center">
                <x-authentication-card-logo alt="OurBooks.top logo" />
            </div>
            <p>What can OurBookstop do for you?</p>
            <ul>
                <li>Track your books</li>
                <li>Easily search and filter your books</li>
                <li>Share your list with friends and family</li>
                <li>Collaboratively rate and review your books</li>
            </ul>
        </div>
    </div>
</x-guest-layout>
