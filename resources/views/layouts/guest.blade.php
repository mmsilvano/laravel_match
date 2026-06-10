<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaravelMatch') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-md">
                <div class="mb-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-3 text-gray-900">
                        <x-application-logo class="h-12 w-12" />
                        <span class="text-2xl font-bold tracking-tight">LaravelMatch</span>
                    </a>
                    <p class="mt-3 text-sm text-gray-500">Clean connections, server-rendered.</p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white px-6 py-8 shadow-sm sm:px-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
