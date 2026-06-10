<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $members = User::query()
            ->excluding($user)
            ->latest('id')
            ->paginate(12);

        return view('members.index', [
            'members' => $members,
        ]);
    }
}
