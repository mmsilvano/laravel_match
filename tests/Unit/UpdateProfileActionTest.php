<?php

declare(strict_types=1);

use App\Actions\Profiles\UpdateProfileAction;
use App\Models\User;

test('updates user name age and bio correctly', function () {
    $user = User::factory()->create();

    app(UpdateProfileAction::class)->execute($user, [
        'name' => 'Updated',
        'age' => 34,
        'bio' => 'New bio',
    ]);

    expect($user->fresh())
        ->name->toBe('Updated')
        ->age->toBe(34)
        ->bio->toBe('New bio');
});

test('returns updated user model', function () {
    $user = User::factory()->create();

    $updatedUser = app(UpdateProfileAction::class)->execute($user, [
        'name' => 'Updated',
        'age' => 34,
        'bio' => 'New bio',
    ]);

    expect($updatedUser)->toBeInstanceOf(User::class)
        ->and($updatedUser->name)->toBe('Updated');
});
