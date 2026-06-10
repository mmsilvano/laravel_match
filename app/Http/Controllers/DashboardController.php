<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $recentConversations = Conversation::query()
            ->where(fn ($query) => $query
                ->where('user_one_id', $user->getKey())
                ->orWhere('user_two_id', $user->getKey()))
            ->with(['userOne', 'userTwo', 'latestMessage.sender'])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'memberCount' => User::query()->excluding($user)->count(),
            'conversationCount' => $user->conversations()->count(),
            'sentMessageCount' => $user->sentMessages()->count(),
            'recentConversations' => $recentConversations,
        ]);
    }
}
