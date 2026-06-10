<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Conversations\CreateConversationAction;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function __construct(
        private readonly CreateConversationAction $createConversationAction,
    ) {}

    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        return view('conversations.index', [
            'conversations' => $this->conversationList($user),
        ]);
    }

    public function store(User $member, Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->is($member)) {
            return back()->with('error', 'You cannot start a conversation with yourself.');
        }

        $conversation = $this->createConversationAction->execute($user, $member);

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation, Request $request): View
    {
        $this->authorize('view', $conversation);

        /** @var User $user */
        $user = $request->user();

        abort_if($conversation->user_one_id === $conversation->user_two_id, 404);

        $conversation->load(['userOne', 'userTwo']);

        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', $user->getKey())
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->simplePaginate(15);

        return view('conversations.show', [
            'conversations' => $this->conversationList($user),
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    private function conversationList(User $user): LengthAwarePaginator
    {
        return Conversation::query()
            ->whereColumn('user_one_id', '!=', 'user_two_id')
            ->where(fn ($query) => $query
                ->where('user_one_id', $user->getKey())
                ->orWhere('user_two_id', $user->getKey()))
            ->with(['userOne', 'userTwo', 'latestMessage.sender'])
            ->withCount([
                'messages as unread_messages_count' => fn ($query) => $query
                    ->whereNull('read_at')
                    ->where('sender_id', '!=', $user->getKey()),
            ])
            ->latest('updated_at')
            ->paginate(20);
    }
}
