@props(['active' => false])

@php
    $classes = $active 
                ? 'bg-gray-900 text-white' 
                : 'text-gray-300 hover:bg-gray-700 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' flex px-3 py-2 text-sm font-medium']) }} aria-current="{{ $active ? 'page' : false }}">
    {{ $slot }}
</a>
