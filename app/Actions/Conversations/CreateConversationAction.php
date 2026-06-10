<?php

declare(strict_types=1);

namespace App\Actions\Conversations;

use App\Models\Conversation;
use App\Models\User;

class CreateConversationAction
{
    public function execute(User $initiator, User $recipient): Conversation
    {
        if ($initiator->is($recipient)) {
            abort(422, 'Cannot create conversation with same user.');
        }

        $orderedIds = [$initiator->getKey(), $recipient->getKey()];
        sort($orderedIds);

        return Conversation::query()->firstOrCreate([
            'user_one_id' => $orderedIds[0],
            'user_two_id' => $orderedIds[1],
        ]);
    }
}
