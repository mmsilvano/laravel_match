<?php

declare(strict_types=1);

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
