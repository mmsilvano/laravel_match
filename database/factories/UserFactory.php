<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * @var list<string>
     */
    private array $bios = [
        'Coffee enthusiast and weekend hiker. Looking for someone to explore new trails with.',
        'Dog dad, amateur chef, and terrible at parallel parking.',
        'Bookworm by day, live music fan by night.',
        'Travel addict who has been to 23 countries and counting.',
        'I make a mean carbonara. That is probably my best quality.',
        'Yoga instructor who also loves dive bars. Balance is everything.',
        'Architecture nerd with a soft spot for old films and good wine.',
        'Startup life by day, sourdough experiments by night.',
        'Always planning my next beach trip and my next dinner reservation.',
        'Museum dates, indie playlists, and long walks with no destination.',
        'Runner on weekdays, brunch optimist on weekends.',
        'Photographer who still prints favorite moments.',
        'I collect cookbooks and still order fries for the table.',
        'Equal parts ambitious and homebody.',
        'Looking for laughter, good conversation, and a shared dessert.',
        'Casual cyclist, serious playlist curator.',
    ];

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Ava Brooks', 'Liam Carter', 'Mia Bennett', 'Noah Foster', 'Emma Hayes',
                'Elijah Cooper', 'Sofia Reed', 'Lucas Ward', 'Chloe Griffin', 'Mason Price',
                'Isla Morgan', 'Ethan Bell', 'Harper Collins', 'James Rivera', 'Grace Simmons',
                'Logan Hughes', 'Nora Bailey', 'Henry Flores', 'Ella Sanders', 'Jack Bennett',
            ]),
            'email' => fake()->unique()->safeEmail(),
            'age' => fake()->numberBetween(22, 45),
            'bio' => fake()->randomElement($this->bios),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }
}
