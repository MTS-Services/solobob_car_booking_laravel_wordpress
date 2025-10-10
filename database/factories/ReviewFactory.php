<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookingId = Booking::query()->inRandomOrder()->value('id') ?? Booking::factory()->create()->id;
        $userId = User::query()->inRandomOrder()->value('id') ?? User::factory()->create()->id;

        return [
            'booking_id' => $bookingId,
            'user_id'    => $userId,
            'rating'     => $this->faker->numberBetween(1, 5),
            'title'      => $this->faker->sentence(),
            'comment'    => $this->faker->sentence(),
            // ✅ Single random value, not array
            'status'     => $this->faker->randomElement([
                Review::STATUS_PENDING,
                Review::STATUS_PUBLISHED,
                Review::STATUS_FLAGGED,
            ]),
        ];
    }
}