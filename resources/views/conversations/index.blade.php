<x-app-layout>
    <div class="grid gap-6 md:grid-cols-3">
        <div class="md:col-span-1">
            @include('conversations._list', ['conversations' => $conversations, 'activeConversation' => null])
        </div>

        <div class="hidden md:col-span-2 md:block">
            <div class="flex h-full min-h-[38rem] items-center justify-center rounded-3xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                <div>
                    <p class="text-lg font-semibold text-gray-900">Select a conversation to start reading.</p>
                    <p class="mt-2 text-sm text-gray-500">Open any thread from left column or browse members to begin.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
