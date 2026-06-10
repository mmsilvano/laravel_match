<?php

declare(strict_types=1);

namespace App\Actions\Conversations;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class SendMessageAction
{
    public function execute(Conversation $conversation, User $sender, string $body): Message
    {
        $message = $conversation->messages()->create([
            'sender_id' => $sender->getKey(),
            'body' => $body,
        ]);

        $conversation->touch();

        return $message;
    }
}
