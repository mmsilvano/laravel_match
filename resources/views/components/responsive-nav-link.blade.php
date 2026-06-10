@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block rounded-2xl bg-pink-50 px-4 py-3 text-sm font-semibold text-pink-700'
        : 'block rounded-2xl px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
