<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Actions\Conversations\CreateConversationAction;
use App\Actions\Conversations\SendMessageAction;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $createConversation = app(CreateConversationAction::class);
        $sendMessage = app(SendMessageAction::class);

        $demoUser = User::factory()->create([
            'name' => 'Daniel Hart',
            'email' => 'demo@laravelmatch.test',
            'age' => 29,
            'bio' => 'Builder by day, ramen hunter by night. Looking for easy conversation and great chemistry.',
            'avatar_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
        ]);

        $members = User::factory(20)->create();
        $allUsers = $members->prepend($demoUser)->values();

        $demoPartners = $members->random(3);

        foreach ($demoPartners as $partner) {
            $conversation = $createConversation->execute($demoUser, $partner);
            $this->seedConversationMessages($conversation, 5, 9, $sendMessage);
        }

        while (Conversation::query()->count() < 15) {
            /** @var Collection<int, User> $pair */
            $pair = $allUsers->random(2)->sortBy('id')->values();
            $conversation = $createConversation->execute($pair[0], $pair[1]);

            if ($conversation->messages()->exists()) {
                continue;
            }

            $this->seedConversationMessages($conversation, 3, 12, $sendMessage);
        }

        $this->command?->info('Demo login: demo@laravelmatch.test / password');
    }

    private function seedConversationMessages(
        Conversation $conversation,
        int $minimum,
        int $maximum,
        SendMessageAction $sendMessage,
    ): void {
        $conversation->loadMissing(['userOne', 'userTwo']);

        $firstParticipant = $conversation->userOne;
        $secondParticipant = $conversation->userTwo;
        $messageCount = random_int($minimum, $maximum);
        $sender = fake()->boolean() ? $firstParticipant : $secondParticipant;

        for ($index = 0; $index < $messageCount; $index++) {
            $sendMessage->execute(
                $conversation,
                $sender,
                fake()->randomElement([
                    'How is your week going so far?',
                    'You seem fun. What is your ideal Sunday?',
                    'Any strong opinions on coffee versus matcha?',
                    'I saw your profile and had to say hi.',
                    'If we planned a first date, where would we go?',
                    'Your bio made me laugh. Needed follow-up.',
                    'What kind of music is on repeat lately?',
                    'I am choosing between tacos and pasta tonight. Thoughts?',
                ]),
            );

            $sender = $sender->is($firstParticipant) ? $secondParticipant : $firstParticipant;
        }
    }
}
