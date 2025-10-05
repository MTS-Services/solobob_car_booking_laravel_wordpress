<?php

namespace Database\Seeders;

use App\Models\VehicleFuel;
use Illuminate\Database\Seeder;

class VehicleFuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuels = [
            'Petrol', 'Diesel', 'CNG', 'Electric', 'Hybrid', 'Hydrogen'
        ];

        foreach ($fuels as $fuel) {
            VehicleFuel::updateOrCreate(
                ['name' => $fuel]
            );
        }
    }
}
