<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $primary = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = User::factory(2000)->create()->add($primary);

        Conversation::factory(50000)->create()->each(function (Conversation $conversation) use ($users) {
            foreach ($users->random(random_int(2, 5)) as $user) {
                Participant::factory()->create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user->id,
                ]);

                // first message
                Message::factory()->create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user->id,
                    'created_at' => $conversation->created_at,
                    'updated_at' => $conversation->created_at,
                ]);

                $maxDate = $conversation->created_at;
                for ($i = 0; $i < random_int(1, 250); $i++) {

                    $date = fake()->dateTimeBetween($maxDate);
                    $maxDate = $date;

                    Message::factory()->create([
                        'conversation_id' => $conversation->id,
                        'user_id' => $user->id,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                }

                // other (next) messages

            }
        });

    }
}
