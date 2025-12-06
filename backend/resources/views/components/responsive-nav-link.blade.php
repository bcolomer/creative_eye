@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#00BBC9] text-start text-base font-medium text-white bg-[#006066] focus:outline-none focus:text-white focus:bg-[#005055] focus:border-[#00BBC9] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#CACACA] hover:text-white hover:bg-[#006066] hover:border-[#CACACA] focus:outline-none focus:text-white focus:bg-[#006066] focus:border-[#CACACA] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
