<?php

namespace Database\Seeders;

use App\Models\{Booking, BookingStatusTimeline};
use Illuminate\Database\Seeder;

class BookingStatusTimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();

        if ($bookings->isEmpty()) {
            $this->command->warn('No bookings found — skipping timeline seeding.');
            return;
        }

        foreach ($bookings as $booking) {
            $statuses = [
                BookingStatusTimeline::STATUS_PENDING,
                BookingStatusTimeline::STATUS_ACCEPTED,
                BookingStatusTimeline::STATUS_DEPOSITED,
                BookingStatusTimeline::STATUS_DELIVERED,
                BookingStatusTimeline::STATUS_RETURNED,
            ];

            foreach ($statuses as $index => $status) {
                BookingStatusTimeline::create([
                    'sort_order'     => $index + 1,
                    'booking_id'     => $booking->id,
                    'booking_status' => $status,
                    'created_by'     => $booking->created_by,
                ]);
            }
        }
    }
}
