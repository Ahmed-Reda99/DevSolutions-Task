<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'sender_id' => $this->faker->numberBetween(1, 10),
            'receiver_id' => $this->faker->numberBetween(1, 10),
            'message' => $this->faker->sentence(),
            'status' => Status::delivered->value
        ];
    }
}
