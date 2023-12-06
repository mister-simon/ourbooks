@props(['rating'])
@if ($rating)
    <span class="table-rating table-rating-{{ round($rating) }} badge badge-lg aspect-square rounded-full text-sm">{{ $rating }}</span>
@else
    <span class="opacity-50">{{ __('N/A') }}</span>
@endif
