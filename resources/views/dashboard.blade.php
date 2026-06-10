<x-app-layout>
    <div class="space-y-8">
        <section class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-pink-600">Dashboard</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">Welcome back, {{ auth()->user()->name }}.</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">Browse members, keep conversations moving, and demo clean Laravel architecture.</p>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Members</p>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ $memberCount }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Your Conversations</p>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ $conversationCount }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Messages Sent</p>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ $sentMessageCount }}</p>
            </div>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Recent Conversations</h2>
                    <p class="mt-1 text-sm text-gray-500">Latest activity across your matches.</p>
                </div>
                <a href="{{ route('conversations.index') }}" class="text-sm font-semibold text-pink-600">View all</a>
            </div>

            @if ($recentConversations->isEmpty())
                <div class="mt-6 rounded-3xl border border-dashed border-gray-200 bg-gray-50 px-6 py-10 text-center">
                    <p class="text-base font-semibold text-gray-900">No conversations yet.</p>
                    <p class="mt-2 text-sm text-gray-500">Browse members to start one.</p>
                    <a href="{{ route('members.index') }}" class="mt-5 inline-flex rounded-2xl bg-pink-600 px-4 py-2.5 text-sm font-semibold text-white">Browse Members</a>
                </div>
            @else
                <div class="mt-6 space-y-4">
                    @foreach ($recentConversations as $conversation)
                        @php($participant = $conversation->otherParticipant(auth()->user()))
                        <a href="{{ route('conversations.show', $conversation) }}" class="flex items-center justify-between rounded-3xl border border-gray-200 p-4 transition hover:border-pink-200 hover:bg-pink-50/40">
                            <div>
                                <div class="flex items-center gap-3">
                                    <p class="font-semibold text-gray-900">{{ $participant->name }}</p>
                                    <span class="rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700">{{ $participant->age }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">{{ $conversation->latestMessage?->body ?? 'Conversation ready. Say hello.' }}</p>
                            </div>
                            <p class="text-xs text-gray-400">{{ $conversation->updated_at->diffForHumans() }}</p>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
