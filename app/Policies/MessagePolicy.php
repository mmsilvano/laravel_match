<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function create(User $user, Conversation $conversation): bool
    {
        return in_array($user->getKey(), [$conversation->user_one_id, $conversation->user_two_id], true);
    }

    public function view(User $user, Message $message): bool
    {
        return $this->create($user, $message->conversation);
    }
}
