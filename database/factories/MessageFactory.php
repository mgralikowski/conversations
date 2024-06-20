<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTime();

        return [
            'user_id' => User::factory(),
            'content' => $this->faker->text(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    public function afterDate(string|Carbon $minDate): MessageFactory|Factory
    {
        return $this->state(function () use ($minDate) {
            $date = $this->faker->dateTimeBetween($minDate);
            return [
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
