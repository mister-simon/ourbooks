<x-guest-layout>
    @livewire('navigation-menu')

    <div class="flex grow flex-col items-center overflow-hidden bg-gray-100 pt-6 sm:justify-center sm:pt-0">
        <div
            class="welcome-book my-8"
            :class="{ 'active': open }"
            :style="{
                '--x': x,
                '--y': y,
                '--z': z,
            }"
            x-data="welcomeBook"
            x-bind="bindings">
            <div class="front-cover">
                <div class="flex flex-col items-center justify-center gap-4 text-center">
                    <x-authentication-card-logo alt="OurBooks.top logo" />
                    <h2 class="heading text-2xl">Welcome To OurBookstop</h2>
                </div>
            </div>
            <div class="inner-left">
                Well Hello There
            </div>
            <div class="inner-right">
                <div class="prose">
                    <p class="text-center"><strong>What can OurBookstop do for you?</strong></p>
                    <ul>
                        <li>Track your books</li>
                        <li>Easily search and filter your books</li>
                        <li>Share your list with friends and family</li>
                        <li>Collaboratively rate and review your books</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
