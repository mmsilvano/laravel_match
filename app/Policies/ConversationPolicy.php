<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        return in_array($user->getKey(), [$conversation->user_one_id, $conversation->user_two_id], true);
    }
}
