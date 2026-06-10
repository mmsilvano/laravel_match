<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $excludedMemberIds = Conversation::query()
            ->whereColumn('user_one_id', '!=', 'user_two_id')
            ->where(fn ($query) => $query
                ->where('user_one_id', $user->getKey())
                ->orWhere('user_two_id', $user->getKey()))
            ->get(['user_one_id', 'user_two_id'])
            ->flatMap(fn (Conversation $conversation): array => [
                $conversation->user_one_id,
                $conversation->user_two_id,
            ])
            ->filter(fn (int $memberId): bool => $memberId !== $user->getKey())
            ->unique()
            ->values();

        $members = User::query()
            ->excluding($user)
            ->when(
                $excludedMemberIds->isNotEmpty(),
                fn ($query) => $query->whereNotIn('id', $excludedMemberIds->all()),
            )
            ->latest('id')
            ->paginate(12);

        return view('members.index', [
            'members' => $members,
        ]);
    }
}
