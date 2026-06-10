<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Welcome back</h1>
        <p class="mt-2 text-sm text-gray-500">Sign in to continue matching and messaging.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Password" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-pink-600" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-3 text-sm text-gray-600">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-600 focus:ring-pink-500" name="remember">
            <span>Remember me</span>
        </label>

        <x-primary-button class="w-full">Log in</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        New here?
        <a href="{{ route('register') }}" class="font-semibold text-pink-600">Create account</a>
    </p>
</x-guest-layout>
