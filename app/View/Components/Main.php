<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Mary\View\Components\Main as MaryMain;

class Main extends MaryMain
{
    public function __construct(

        // Slots
        public mixed $sidebar = null,
        public mixed $content = null,
        public mixed $footer = null,
        public bool $hideSidebar = false,
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                 <main {{ $sidebar->attributes->class(["flex flex-col grow"]) }}>
                    <div class="w-full mx-auto max-w-screen-2xl flex grow">
                        @if($sidebar && !$hideSidebar)
                                {{ $sidebar }}
                        @endif

                        <div {{ $content->attributes->class(["flex-1 mx-auto w-full p-5 lg:p-10 grow"]) }}>
                            {{ $content }}
                        </div>
                    </div>

                    @if($footer)
                        <div {{ $footer->attributes->class(["max-w-screen-2xl mx-auto w-full"]) }}>
                            {{ $footer }}
                        </div>
                    @endif

                    @if($sidebar?->attributes['drawer'])
                        <x-drawer id="{{ $sidebar->attributes['drawer'] }}" :attributes="$sidebarDrawer->attributes">
                            {{ $sidebarDrawer }}
                        </x-drawer>
                    @endif
                </main>
                HTML;
    }
}
