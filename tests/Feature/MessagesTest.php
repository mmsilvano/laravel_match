<?php

declare(strict_types=1);

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

test('user can send a message in conversation they belong to', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
    ]);

    $this->actingAs($sender)
        ->post(route('conversations.messages.store', $conversation), [
            'body' => 'Hello there',
        ])
        ->assertRedirect(route('conversations.show', $conversation));

    $message = Message::first();

    expect($message)->not->toBeNull()
        ->conversation_id->toBe($conversation->id)
        ->sender_id->toBe($sender->id)
        ->body->toBe('Hello there');
});

test('message body is required', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
    ]);

    $this->actingAs($sender)
        ->from(route('conversations.show', $conversation))
        ->post(route('conversations.messages.store', $conversation), [
            'body' => '',
        ])
        ->assertRedirect(route('conversations.show', $conversation))
        ->assertSessionHasErrors('body');
});

test('message body cannot exceed 1000 characters', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
    ]);

    $this->actingAs($sender)
        ->from(route('conversations.show', $conversation))
        ->post(route('conversations.messages.store', $conversation), [
            'body' => str_repeat('a', 1001),
        ])
        ->assertRedirect(route('conversations.show', $conversation))
        ->assertSessionHasErrors('body');
});

test('messages are marked as read when conversation is opened', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
    ]);

    $message = Message::create([
        'conversation_id' => $conversation->id,
        'sender_id' => $sender->id,
        'body' => 'Unread message',
    ]);

    $this->actingAs($recipient)
        ->get(route('conversations.show', $conversation))
        ->assertOk();

    expect($message->fresh()->read_at)->not->toBeNull();
});

test('unread count decrements when messages are read', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();
    $conversation = Conversation::create([
        'user_one_id' => min($sender->id, $recipient->id),
        'user_two_id' => max($sender->id, $recipient->id),
    ]);

    Message::create([
        'conversation_id' => $conversation->id,
        'sender_id' => $sender->id,
        'body' => 'Unread message',
    ]);

    expect($conversation->unreadCountFor($recipient))->toBe(1);

    $this->actingAs($recipient)->get(route('conversations.show', $conversation));

    expect($conversation->fresh()->unreadCountFor($recipient))->toBe(0);
});
