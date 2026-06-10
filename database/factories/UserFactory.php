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
     * @var list<array{name: string, avatar_url: string}>
     */
    private array $femaleProfiles = [
        ['name' => 'Ava Brooks', 'avatar_url' => 'https://randomuser.me/api/portraits/women/1.jpg'],
        ['name' => 'Mia Bennett', 'avatar_url' => 'https://randomuser.me/api/portraits/women/2.jpg'],
        ['name' => 'Lily Foster', 'avatar_url' => 'https://randomuser.me/api/portraits/women/3.jpg'],
        ['name' => 'Sofia Reed', 'avatar_url' => 'https://randomuser.me/api/portraits/women/4.jpg'],
        ['name' => 'Chloe Griffin', 'avatar_url' => 'https://randomuser.me/api/portraits/women/5.jpg'],
        ['name' => 'Isla Morgan', 'avatar_url' => 'https://randomuser.me/api/portraits/women/6.jpg'],
        ['name' => 'Harper Collins', 'avatar_url' => 'https://randomuser.me/api/portraits/women/7.jpg'],
        ['name' => 'Grace Simmons', 'avatar_url' => 'https://randomuser.me/api/portraits/women/8.jpg'],
        ['name' => 'Nora Bailey', 'avatar_url' => 'https://randomuser.me/api/portraits/women/9.jpg'],
        ['name' => 'Ella Sanders', 'avatar_url' => 'https://randomuser.me/api/portraits/women/10.jpg'],
        ['name' => 'Zoey Carter', 'avatar_url' => 'https://randomuser.me/api/portraits/women/11.jpg'],
        ['name' => 'Ruby Bennett', 'avatar_url' => 'https://randomuser.me/api/portraits/women/12.jpg'],
        ['name' => 'Hannah Cooper', 'avatar_url' => 'https://randomuser.me/api/portraits/women/13.jpg'],
        ['name' => 'Clara Dawson', 'avatar_url' => 'https://randomuser.me/api/portraits/women/14.jpg'],
        ['name' => 'Layla Hughes', 'avatar_url' => 'https://randomuser.me/api/portraits/women/68.jpg'],
        ['name' => 'Stella Reed', 'avatar_url' => 'https://randomuser.me/api/portraits/women/16.jpg'],
        ['name' => 'Lucy Ward', 'avatar_url' => 'https://randomuser.me/api/portraits/women/17.jpg'],
        ['name' => 'Aria Bell', 'avatar_url' => 'https://randomuser.me/api/portraits/women/18.jpg'],
        ['name' => 'Maya Flores', 'avatar_url' => 'https://randomuser.me/api/portraits/women/19.jpg'],
        ['name' => 'Sadie Price', 'avatar_url' => 'https://randomuser.me/api/portraits/women/20.jpg'],
    ];

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
        $profile = fake()->randomElement($this->femaleProfiles);

        return [
            'name' => $profile['name'],
            'email' => fake()->unique()->safeEmail(),
            'age' => fake()->numberBetween(22, 45),
            'bio' => fake()->randomElement($this->bios),
            'avatar_url' => $profile['avatar_url'],
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
