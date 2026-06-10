<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-2xl bg-pink-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
