@props(['active' => false])

@php
$classes = $active
    ? 'bg-blue-50 text-blue-600 font-semibold'
    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800';
@endphp

<a {{ $attributes->merge(['class' => 'w-full flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-150 ease-in-out ' . $classes]) }}>
    {{ $slot }}
</a>
