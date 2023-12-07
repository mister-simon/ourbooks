@props(['rating'])
@if ($rating)
    <span class="table-rating table-rating-{{ round($rating) }} badge badge-lg aspect-square rounded-full text-sm transition-[background-position] duration-1000">{{ $rating }}</span>
@else
    <span class="opacity-50">{{ __('N/A') }}</span>
@endif
