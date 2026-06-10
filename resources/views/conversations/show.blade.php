<x-app-layout>
    <div class="flex flex-col gap-6 md:grid md:grid-cols-3">
        <div class="order-2 md:order-1 md:col-span-1">
            @include('conversations._list', ['conversations' => $conversations, 'activeConversation' => $conversation])
        </div>

        <div class="order-1 md:order-2 md:col-span-2">
            @php($participant = $conversation->otherParticipant(auth()->user()))

            <div class="flex min-h-[70dvh] flex-col overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm md:min-h-[38rem]">
                <div class="border-b border-gray-200 px-5 py-4">
                    <a href="{{ route('conversations.index') }}" class="mb-3 inline-flex text-sm font-medium text-gray-500 md:hidden">← Back</a>
                    <div class="flex items-center gap-3">
                        <img src="{{ $participant->profilePhotoUrl() }}" alt="{{ $participant->name }}" class="h-12 w-12 rounded-full object-cover">
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">{{ $participant->name }}</h1>
                            <p class="text-sm text-gray-500">{{ $participant->age }} years old</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 space-y-4 overflow-y-auto px-4 py-4 sm:px-5 sm:py-5">
                    @if ($messages->isEmpty())
                        <div class="flex h-full items-center justify-center text-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">Say hello to {{ $participant->name }}!</p>
                                <p class="mt-2 text-sm text-gray-500">Conversation exists. First message still missing.</p>
                            </div>
                        </div>
                    @else
                        @foreach ($messages as $message)
                            @php($isOwnMessage = $message->sender->is(auth()->user()))
                            <div @class(['flex', 'justify-end' => $isOwnMessage, 'justify-start' => ! $isOwnMessage])>
                                <div class="@class([
                                    'max-w-[85%] rounded-3xl px-4 py-3 shadow-sm sm:max-w-xl',
                                    'bg-pink-500 text-white rounded-br-md' => $isOwnMessage,
                                    'bg-gray-100 text-gray-800 rounded-bl-md' => ! $isOwnMessage,
                                ])">
                                    @unless ($isOwnMessage)
                                        <p class="mb-1 text-xs font-semibold text-gray-600">{{ $message->sender->name }}</p>
                                    @endunless
                                    <p class="text-sm leading-6">{{ $message->body }}</p>
                                    <p class="@class([
                                        'mt-2 text-xs',
                                        'text-right' => $isOwnMessage,
                                        'text-left' => ! $isOwnMessage,
                                        'text-pink-100' => $isOwnMessage,
                                        'text-gray-400' => ! $isOwnMessage,
                                    ])">{{ $message->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-2">
                            {{ $messages->links() }}
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 bg-white px-4 py-4 sm:px-5">
                    <form method="POST" action="{{ route('conversations.messages.store', $conversation) }}" class="space-y-3">
                        @csrf
                        <textarea name="body" rows="3" class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Write your message...">{{ old('body') }}</textarea>
                        <x-input-error :messages="$errors->get('body')" />

                        <div class="flex justify-stretch sm:justify-end">
                            <x-primary-button class="w-full sm:w-auto">Send message</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
