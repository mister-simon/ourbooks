<x-guest-layout>
    @livewire('navigation-menu')

    <div class="flex grow flex-col items-center overflow-hidden bg-gray-100 py-6 md:justify-center">
        <div
            class="welcome-book my-auto"
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
                    <h2 class="heading text-2xl">{{ __('Welcome To OurBookstop') }}</h2>
                </div>
            </div>
            <div class="inner-left p-4">
                <div class="prose">
                    {!! str(__('welcome.intro'))->attributeMarkdown() !!}
                </div>
            </div>
            <div class="inner-right p-4">
                <div class="prose">
                    {!! str(__('welcome.outline'))->attributeMarkdown() !!}
                    <a
                        wire:navigate
                        href="{{ route('login') }}"
                        class="btn btn-primary mx-auto flex">
                        {{ __('Login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
