<?php

declare(strict_types=1);

test('registration screen can be rendered', function () {
    $this->get('/register')->assertOk();
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'age' => 24,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard'));
});

test('user cannot register under age 18', function () {
    $response = $this->from('/register')->post('/register', [
        'name' => 'Too Young',
        'email' => 'young@example.com',
        'age' => 17,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('age');
    $this->assertGuest();
});
