@props(['user'])
@php($profilePhotos = Laravel\Jetstream\Jetstream::managesProfilePhotos())
<li {{ $attributes->class('badge badge-neutral badge-sm h-auto gap-2' . ($profilePhotos ? ' pl-0' : '')) }}>
    @if ($profilePhotos)
        <img class="h-6 w-6 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="" />
    @endif
    {{ $user->readable }}
</li>
