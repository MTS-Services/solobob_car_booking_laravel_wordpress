<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleAvailabillity;
use Illuminate\Database\Seeder;

class VehicleAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            for ($i = 1; $i <= 5; $i++) {
                VehicleAvailabillity::updateOrCreate(
                    [
                        'vehicle_id' => $vehicle->id,
                        'unavailable_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                    ],
                    [
                        'reason' => VehicleAvailabillity::REASON_BOOKED,
                    ]
                );
            }
        }
    }
}
