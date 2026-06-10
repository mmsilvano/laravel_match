<x-app-layout>
    <div class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-5">
                    <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-3xl object-cover shadow-sm">
                    <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-pink-600">Profile</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ $user->name }}</h1>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="rounded-2xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">Edit</a>
            </div>

            <div class="mt-8 grid gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Age</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $user->age }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Bio</p>
                    <p class="mt-2 text-sm leading-7 text-gray-700">{{ $user->bio ?: 'No bio yet.' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-2 text-sm text-gray-700">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
