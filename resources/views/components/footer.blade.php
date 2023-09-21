<div class="mt-auto flex items-end">
    <x-link class="m-2 inline-flex items-center gap-2 text-xs" href="{{ route('terms') }}">Terms Of Service</x-link>
    <x-link class="m-2 inline-flex items-center gap-2 text-xs" href="{{ route('privacy') }}">Privacy Policy</x-link>

    <div class="alert alert-warning mx-auto mx-auto mb-4 max-w-screen-sm text-xs">
        <div class="space-y-2">
            <p>This site is still very much under construction, and is currently running as a personal project for me to mess around and learn some stuff.</p>
            <p>It generally works, but it's highly likely that things are going to change dramatically.</p>
        </div>
    </div>

    <x-link
        href="https://github.com/mister-simon/ourbooks"
        target="_blank"
        rel="noopener noreferrer"
        class="m-2 ml-auto inline-flex items-center gap-2 text-xs">
        Github
        @svg('heroicon-o-code-bracket', 'w-3 h-3')
    </x-link>
</div>
