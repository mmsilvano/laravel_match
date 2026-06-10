<?php

declare(strict_types=1);

test('guest is redirected to login for protected routes', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
    $this->get(route('members.index'))->assertRedirect(route('login'));
    $this->get(route('conversations.index'))->assertRedirect(route('login'));
    $this->get(route('profile.show'))->assertRedirect(route('login'));
});
