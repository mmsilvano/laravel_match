@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center gap-2 text-sm font-semibold text-pink-600'
        : 'inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
