@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'mt-1 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-pink-500']) }}>
