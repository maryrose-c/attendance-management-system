@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center h-16 px-3 border-b-2 border-violet-400 text-sm font-black text-white transition duration-150 ease-in-out'
            : 'inline-flex items-center h-16 px-3 border-b-2 border-transparent text-sm font-bold text-purple-200/80 hover:text-white hover:border-violet-400/40 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
