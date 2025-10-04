<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            VehicleMakeSeeder::class,
            VehicleModelSeeder::class,
            VehicleFuelSeeder::class,
            VehicleFeatureSeeder::class,
            VehicleImageSeeder::class,
            VehicleRelationSeeder::class,
            VehicleLocationSeeder::class,
            VehicleSeeder::class,
            BookingSeeder::class,
            BookingStatusTimelineSeeder::class,
            RentalCheckinsSeeder::class,

            PaymentSeeder::class,
        ]);
    }
}
