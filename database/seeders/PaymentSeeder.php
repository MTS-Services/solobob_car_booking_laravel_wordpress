<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $bookings = Booking::all();
        $users = User::all();

        if ($bookings->isEmpty() || $users->isEmpty()) {
            $this->command->warn('⚠️ No bookings or users found — skipping PaymentSeeder.');
            return;
        }

        foreach ($bookings as $booking) {
            Payment::create([
                'sort_order' => rand(1, 50),
                'booking_id' => $booking->id,
                'user_id' => $users->random()->id,
                'payment_method' => fake()->randomElement([Payment::METHOD_STRIPE, Payment::METHOD_PAYPAL]),
                'type' => fake()->randomElement([Payment::TYPE_DEPOSIT, Payment::TYPE_FINAL, Payment::TYPE_ADDITIONAL]),
                'status' => fake()->randomElement([
                    Payment::STATUS_PENDING,
                    Payment::STATUS_PAID,
                    Payment::STATUS_REFUNDED,
                    Payment::STATUS_FAILED,
                ]),
                'amount' => fake()->randomFloat(2, 50, 1000),
                'note' => fake()->sentence(),
                'created_by' => $users->random()->id,
            ]);
        }

        $this->command->info('✅ PaymentSeeder completed successfully.');

    }
}
