<x-app-layout>
    <div class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-pink-600">Profile</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Edit profile</h1>
                </div>
                <a href="{{ route('profile.show') }}" class="rounded-2xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">View</a>
            </div>

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="age" value="Age" />
                    <x-text-input id="age" type="number" min="18" max="99" name="age" :value="old('age', $user->age)" required />
                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="bio" value="Bio" />
                    <textarea id="bio" name="bio" rows="5" class="mt-1 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Save changes</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
