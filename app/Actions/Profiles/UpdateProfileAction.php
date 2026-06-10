<?php

declare(strict_types=1);

namespace App\Actions\Profiles;

use App\Models\User;

class UpdateProfileAction
{
    /**
     * @param  array{name: string, age: int, bio?: ?string}  $data
     */
    public function execute(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'age' => $data['age'],
            'bio' => $data['bio'] ?? null,
        ]);

        return $user->refresh();
    }
}
