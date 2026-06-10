<?php

declare(strict_types=1);

use App\Models\Conversation;
use App\Models\User;

test('clicking message on a member creates a conversation and redirects to it', function () {
    $user = User::factory()->create();
    $member = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('members.conversations.store', $member));

    $conversation = Conversation::first();

    expect($conversation)->not->toBeNull();
    $response->assertRedirect(route('conversations.show', $conversation));
});

test('clicking message on same member twice reuses existing conversation', function () {
    $user = User::factory()->create();
    $member = User::factory()->create();

    $this->actingAs($user)->post(route('members.conversations.store', $member));
    $this->actingAs($user)->post(route('members.conversations.store', $member));

    expect(Conversation::count())->toBe(1);
});

test('user cannot view a conversation they are not part of', function () {
    $user = User::factory()->create();
    $conversation = Conversation::factory()->create();

    $this->actingAs($user)
        ->get(route('conversations.show', $conversation))
        ->assertForbidden();
});

test('user cannot start a conversation with themselves', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('members.index'))
        ->post(route('members.conversations.store', $user))
        ->assertRedirect(route('members.index'))
        ->assertSessionHas('error');
});
