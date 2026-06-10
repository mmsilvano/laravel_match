<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Browse Members</h1>
            <p class="mt-2 text-sm text-gray-500">Find people worth messaging.</p>
        </div>

        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($members->isEmpty())
            <div class="rounded-3xl border border-dashed border-gray-200 bg-white px-6 py-16 text-center shadow-sm">
                <p class="text-lg font-semibold text-gray-900">No members found.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($members as $member)
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $member->name }}</h2>
                            <span class="rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700">{{ $member->age }}</span>
                        </div>
                        <p class="mt-4 line-clamp-2 text-sm leading-6 text-gray-500">{{ $member->bio ?: 'No bio yet.' }}</p>

                        <form method="POST" action="{{ route('members.conversations.store', $member) }}" class="mt-6">
                            @csrf
                            <x-primary-button class="w-full">Message</x-primary-button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $members->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
