<nav x-data="{ open: false }" class="sticky top-0 z-30 border-b border-gray-200 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 text-gray-900">
                <x-application-logo class="h-9 w-9" />
                <span class="text-lg font-bold tracking-tight">LaravelMatch</span>
            </a>

            <div class="hidden items-center gap-6 md:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">Browse</x-nav-link>
                <x-nav-link :href="route('conversations.index')" :active="request()->routeIs('conversations.*')">
                    Messages
                    @if ($navigationUnreadCount > 0)
                        <span class="rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700">{{ $navigationUnreadCount }}</span>
                    @endif
                </x-nav-link>
                <x-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.*')">Profile</x-nav-link>
            </div>
        </div>

        <div class="hidden items-center gap-4 md:flex">
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="inline-flex items-center rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200">
                    Logout
                </button>
            </form>
        </div>

        <button @click="open = ! open" class="inline-flex items-center rounded-xl border border-gray-200 p-2 text-gray-600 md:hidden">
            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-cloak class="border-t border-gray-200 bg-white md:hidden">
        <div class="space-y-1 px-4 py-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">Browse</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('conversations.index')" :active="request()->routeIs('conversations.*')">
                Messages @if ($navigationUnreadCount > 0) ({{ $navigationUnreadCount }}) @endif
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.*')">Profile</x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 px-4 py-4">
            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button class="w-full rounded-2xl bg-gray-100 px-4 py-2 text-left text-sm font-medium text-gray-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
