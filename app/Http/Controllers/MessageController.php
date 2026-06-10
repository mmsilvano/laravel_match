<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Conversations\SendMessageAction;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function __construct(
        private readonly SendMessageAction $sendMessageAction,
    ) {}

    public function store(StoreMessageRequest $request, Conversation $conversation): RedirectResponse
    {
        $this->authorize('create', [Message::class, $conversation]);

        /** @var User $user */
        $user = $request->user();

        $this->sendMessageAction->execute(
            $conversation,
            $user,
            $request->validated('body'),
        );

        return redirect()->route('conversations.show', $conversation);
    }
}
