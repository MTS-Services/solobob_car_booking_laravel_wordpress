<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Database\Seeder;

class VehicleImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            for ($i = 1; $i <= 3; $i++) {
                VehicleImage::updateOrCreate(
                    [
                        'vehicle_id' => $vehicle->id,
                        'order_image' => $i,
                    ],
                    [
                        'image_url' => "https://example.com/images/vehicles/{$vehicle->slug}_{$i}.jpg",
                        'is_primary' => $i === 1,
                    ]
                );
            }
        }
    }
}
