<?php

declare(strict_types=1);

use App\Models\Conversation;
use App\Models\User;

test('browse page returns 200 for authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('members.index'))
        ->assertOk();
});

test('auth user does not appear in their own browse list', function () {
    $user = User::factory()->create(['name' => 'Visible User']);
    User::factory()->create(['name' => 'Other User']);

    $this->actingAs($user)
        ->get(route('members.index'))
        ->assertOk()
        ->assertViewHas('members', fn ($members) => $members->contains(fn ($member) => $member->is($user)) === false)
        ->assertSee('Other User');
});

test('browse is paginated', function () {
    $user = User::factory()->create();
    User::factory()->count(13)->create();

    $this->actingAs($user)
        ->get(route('members.index'))
        ->assertOk()
        ->assertViewHas('members', fn ($members) => $members->perPage() === 12 && $members->total() === 13);
});

test('members with existing conversations do not appear in browse', function () {
    $user = User::factory()->create();
    $matchedMember = User::factory()->create(['name' => 'Matched Member']);
    $availableMember = User::factory()->create(['name' => 'Available Member']);

    Conversation::create([
        'user_one_id' => min($user->id, $matchedMember->id),
        'user_two_id' => max($user->id, $matchedMember->id),
    ]);

    $this->actingAs($user)
        ->get(route('members.index'))
        ->assertOk()
        ->assertDontSee('Matched Member')
        ->assertSee('Available Member')
        ->assertViewHas('members', fn ($members) => $members->contains(fn ($member) => $member->is($matchedMember)) === false);
});
