<?php

declare(strict_types=1);

use App\Actions\Conversations\SendMessageAction;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Carbon;

test('creates message with correct conversation id sender id and body', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
    ]);

    $message = app(SendMessageAction::class)->execute($conversation, $sender, 'Test body');

    expect($message->conversation_id)->toBe($conversation->id)
        ->and($message->sender_id)->toBe($sender->id)
        ->and($message->body)->toBe('Test body');
});

test('touches conversation updated at after sending', function () {
    Carbon::setTestNow(now());

    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
        'updated_at' => now()->subMinute(),
    ]);

    $previousUpdatedAt = $conversation->updated_at;

    Carbon::setTestNow(now()->addMinute());

    app(SendMessageAction::class)->execute($conversation, $sender, 'Another message');

    expect($conversation->fresh()->updated_at->greaterThan($previousUpdatedAt))->toBeTrue();
});
