<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleLocation;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $vehicles = Vehicle::all();
        $locations = VehicleLocation::all();

        // Handle empty dependencies
        if ($users->isEmpty() || $vehicles->isEmpty()) {
            $this->command->warn("⚠️ Skipping BookingSeeder — Users or Vehicles table is empty.");
            return;
        }

        foreach (range(1, 20) as $i) {
            $user = $users->random();
            $vehicle = $vehicles->random();
            
            $pickup = $locations->isNotEmpty() ? $locations->random() : null;

            $pickupDate = Carbon::now()->addDays(rand(1, 10));
            $returnDate = (clone $pickupDate)->addDays(rand(1, 5));

            Booking::create([
                'sort_order'        => $i,
                'vehicle_id'        => $vehicle->id,
                'user_id'           => $user->id,
                'pickup_location_id'=> $pickup?->id,
                'audit_by'          => $user->id,
                'booking_reference' => strtoupper(Str::random(10)),
                'pickup_date'       => $pickupDate,
                'return_date'       => $returnDate,
                'booking_date'      => Carbon::now(),
                'return_location'   => fake()->city(),
                'subtotal'          => fake()->randomFloat(2, 100, 1000),
                'delivery_fee'      => fake()->randomFloat(2, 0, 50),
                'service_fee'       => fake()->randomFloat(2, 10, 100),
                'tax_amount'        => fake()->randomFloat(2, 5, 50),
                'security_deposit'  => fake()->randomFloat(2, 50, 200),
                'total_amount'      => fake()->randomFloat(2, 200, 1500),
                'booking_status'    => Booking::BOOKING_STATUS_PENDING,
                'special_requests'  => fake()->sentence(),
                'reason'            => fake()->sentence(),
                'created_by'        => $user->id,
            ]);
        }

        $this->command->info('✅ BookingSeeder completed successfully.');
    
    }
}
