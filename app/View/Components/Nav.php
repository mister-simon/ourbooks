<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Mary\View\Components\Nav as ComponentsNav;

class Nav extends ComponentsNav
{
    public function __construct(
        public bool $sticky = false,

        // Slots
        public mixed $brand = null,
        public mixed $actions = null
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                @if($sticky)
                    <div class="sticky top-0 z-40">
                @endif

                    <header {{ $attributes->class(["bg-base-100 border-gray-100 border-b"]) }}>
                        <div class="max-w-screen-2xl mx-auto px-6 py-5 flex items-center">
                            <div {{ $brand->attributes->class(["flex-1 flex items-center"]) }}>
                                {{ $brand }}
                            </div>
                            <div {{ $actions->attributes->class(["flex items-center gap-4 lg:gap-8"]) }}>
                                {{ $actions }}
                            </div>
                        </div>
                    </header>

                @if($sticky)
                    </div>
                @endif
                HTML;
    }
}
