<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Conversation>
 */
class ConversationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_one_id' => User::factory(),
            'user_two_id' => User::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Conversation $conversation): void {
            $orderedIds = [$conversation->user_one_id, $conversation->user_two_id];
            sort($orderedIds);

            if ($orderedIds === [$conversation->user_one_id, $conversation->user_two_id]) {
                return;
            }

            $conversation->forceFill([
                'user_one_id' => $orderedIds[0],
                'user_two_id' => $orderedIds[1],
            ])->save();
        });
    }
}
