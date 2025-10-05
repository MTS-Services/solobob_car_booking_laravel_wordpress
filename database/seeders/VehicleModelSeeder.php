<?php

namespace Database\Seeders;

use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Corolla',
            'Civic',
            'Accord',
            'Camry',
            'Mustang',
            'Model 3',
            'RAV4',
            'CR-V',
            'Altima',
            'CX-5',
            'Tucson',
            'F-150',
            'Wrangler',
            'A4',
            'X5'
        ];

        foreach ($models as $model) {
            VehicleModel::updateOrCreate(
                ['name' => $model]
            );
        }
    }
}
