<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Profiles\UpdateProfileAction;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UpdateProfileAction $updateProfileAction,
    ) {}

    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->updateProfileAction->execute(
            $request->user(),
            $request->validated(),
        );

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Profile updated successfully.');
    }
}
