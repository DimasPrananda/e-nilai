@props(['active' => false])

@php
    $classes = $active 
                ? 'bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-white' 
                : 'text-gray-800 dark:text-gray-200 hover:bg-gray-200 hover:dark:bg-gray-900 hover:dark:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' flex px-3 py-2 text-sm font-medium']) }} aria-current="{{ $active ? 'page' : false }}">
    {{ $slot }}
</a>
