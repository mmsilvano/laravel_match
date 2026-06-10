@props(['conversations', 'activeConversation' => null])

<div class="rounded-3xl border border-gray-200 bg-white p-2 shadow-sm">
    <div class="border-b border-gray-200 px-5 py-4">
        <h2 class="text-lg font-semibold text-gray-900">Messages</h2>
        <p class="mt-1 text-sm text-gray-500">Your conversations sorted by latest activity.</p>
    </div>

    @if ($conversations->isEmpty())
        <div class="px-5 py-12 text-center">
            <p class="text-base font-semibold text-gray-900">No conversations yet.</p>
            <p class="mt-2 text-sm text-gray-500">Browse members to start one.</p>
            <a href="{{ route('members.index') }}" class="mt-5 inline-flex rounded-2xl bg-pink-600 px-4 py-2.5 text-sm font-semibold text-white">Browse members</a>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach ($conversations as $conversation)
                @php($participant = $conversation->otherParticipant(auth()->user()))
                <a href="{{ route('conversations.show', $conversation) }}" class="@class([
                    'flex items-center gap-4 px-5 py-4 transition hover:bg-gray-50',
                    'bg-pink-50/70' => $activeConversation?->is($conversation),
                ])">
                    <img src="{{ $participant->profilePhotoUrl() }}" alt="{{ $participant->name }}" class="h-12 w-12 rounded-full object-cover">

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <p class="truncate font-semibold text-gray-900">{{ $participant->name }}</p>
                                <span class="rounded-full bg-pink-100 px-2 py-0.5 text-xs font-semibold text-pink-700">{{ $participant->age }}</span>
                            </div>
                            <p class="text-xs text-gray-400">{{ $conversation->updated_at->diffForHumans() }}</p>
                        </div>
                        <p class="mt-1 truncate text-sm text-gray-500">{{ $conversation->latestMessage?->body ?? 'Say hello to '.$participant->name.'!' }}</p>
                    </div>

                    @if ($conversation->unread_messages_count > 0)
                        <span class="rounded-full bg-pink-600 px-2 py-1 text-xs font-semibold text-white">{{ $conversation->unread_messages_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="border-t border-gray-200 px-5 py-4">
            {{ $conversations->links() }}
        </div>
    @endif
</div>
