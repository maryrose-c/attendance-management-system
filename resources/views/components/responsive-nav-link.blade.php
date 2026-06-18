@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl px-4 py-3 text-start text-base font-black text-white bg-violet-600/30 border border-violet-400/30 transition duration-150 ease-in-out'
            : 'block w-full rounded-xl px-4 py-3 text-start text-base font-bold text-purple-200 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
