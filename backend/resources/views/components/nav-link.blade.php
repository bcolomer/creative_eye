@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-4 border-[#00BBC9] text-sm font-medium leading-5 text-white focus:outline-none focus:border-[#00BBC9] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-6 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
