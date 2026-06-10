<?php

declare(strict_types=1);

use App\Models\User;

test('authenticated user can view their profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.show'))
        ->assertOk()
        ->assertSee($user->name);
});

test('authenticated user can update their profile with valid data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'name' => 'Updated Name',
        'age' => 31,
        'bio' => 'Updated bio',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHasNoErrors();

    expect($user->fresh())
        ->name->toBe('Updated Name')
        ->age->toBe(31)
        ->bio->toBe('Updated bio');
});

test('profile update fails with age below 18', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->from(route('profile.edit'))
        ->patch(route('profile.update'), [
            'name' => 'Updated Name',
            'age' => 17,
            'bio' => 'Updated bio',
        ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHasErrors('age');
});

test('profile update fails with bio exceeding 500 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->from(route('profile.edit'))
        ->patch(route('profile.update'), [
            'name' => 'Updated Name',
            'age' => 25,
            'bio' => str_repeat('a', 501),
        ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHasErrors('bio');
});
