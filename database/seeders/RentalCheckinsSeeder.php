<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalCheckinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $now = Carbon::now();

        // Assuming bookings with IDs 1 to 5 exist
        $bookingIds = [1, 2, 3, 4, 5];

        // Fuel level mapping (stored as tinyint)
        // 0 => 'empty', 1 => 'quarter', 2 => 'half', 3 => 'three_quarter', 4 => 'full'
        $fuelLevels = [0, 1, 2, 3, 4];

        $data = [];

        foreach ($bookingIds as $i => $bookingId) {
            $fuelLevel = $faker->randomElement($fuelLevels);

            $data[] = [
                'sort_order' => $i + 1,
                'booking_id' => $bookingId,
                'checkin_datetime' => $now->copy()->subDays(rand(1, 10))->toDateTimeString(),
                'mileage_start' => $faker->numberBetween(10000, 50000),
                'fuel_level_start' => $fuelLevel,
                'vehicle_condition_notes' => $faker->sentence(10),
                'damage_photos' => json_encode([
                    $faker->imageUrl(800, 600, 'car', true, 'damage'),
                    $faker->imageUrl(800, 600, 'car', true, 'scratch'),
                ]),
                'checkin_signature_url' => $faker->imageUrl(400, 200, 'signature', true),
                'performed_by' => $faker->numberBetween(1, 5), // assume users 1-5 exist
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'created_by' => $faker->numberBetween(1, 5),
                'updated_by' => $faker->numberBetween(1, 5),
                'deleted_by' => null,
            ];
        }

        DB::table('rental_checkins')->insert($data);
    }
}
