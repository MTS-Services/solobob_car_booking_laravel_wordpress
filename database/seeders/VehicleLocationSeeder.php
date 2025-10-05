<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleLocation;
use Illuminate\Database\Seeder;

class VehicleLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::all();
        foreach ($vehicles as $vehicle) {
            VehicleLocation::updateOrCreate(
                ['vehicle_id' => $vehicle->id],
                [
                    'address' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'state' => fake()->state(),
                    'postal_code' => fake()->postcode(),
                    'country' => 'USA',
                    'instructions' => fake()->sentence(8),
                ]
            );
        }
    }
}
