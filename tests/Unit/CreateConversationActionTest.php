<?php

declare(strict_types=1);

use App\Actions\Conversations\CreateConversationAction;
use App\Models\Conversation;
use App\Models\User;

test('ids are always normalized', function () {
    $first = User::factory()->create();
    $second = User::factory()->create();

    $conversation = app(CreateConversationAction::class)->execute($second, $first);

    expect($conversation->user_one_id)->toBe(min($first->id, $second->id))
        ->and($conversation->user_two_id)->toBe(max($first->id, $second->id));
});

test('returns existing conversation if one already exists', function () {
    $first = User::factory()->create();
    $second = User::factory()->create();

    $existing = Conversation::create([
        'user_one_id' => min($first->id, $second->id),
        'user_two_id' => max($first->id, $second->id),
    ]);

    $conversation = app(CreateConversationAction::class)->execute($second, $first);

    expect($conversation->is($existing))->toBeTrue()
        ->and(Conversation::count())->toBe(1);
});

test('creates new conversation if none exists', function () {
    $first = User::factory()->create();
    $second = User::factory()->create();

    $conversation = app(CreateConversationAction::class)->execute($first, $second);

    expect($conversation)->toBeInstanceOf(Conversation::class)
        ->and(Conversation::count())->toBe(1);
});
