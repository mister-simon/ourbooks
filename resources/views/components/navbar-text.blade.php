<li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
    <span
        {{ $attributes->merge([
            'class' => 'text-neutral-500 dark:text-neutral-200 lg:px-2',
            'data-te-nav-link-ref',
        ]) }}>{{ $slot }}</span>
</li>
