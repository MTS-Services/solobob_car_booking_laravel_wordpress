<?php

namespace Database\Seeders;

use App\Models\VehicleMake;
use Illuminate\Database\Seeder;

class VehicleMakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makes = [
            'Toyota',
            'Honda',
            'Nissan',
            'Ford',
            'Chevrolet',
            'BMW',
            'Mercedes-Benz',
            'Audi',
            'Volkswagen',
            'Hyundai',
            'Kia',
            'Mazda',
            'Subaru',
            'Jeep',
            'Tesla'
        ];

        foreach ($makes as $make) {
            VehicleMake::updateOrCreate(
                ['name' => $make]
            );
        }
    }
}
