<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleFeature;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRelation;
use App\Models\VehicleTransmission;
use Illuminate\Database\Seeder;

class VehicleRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::all();
        $features = VehicleFeature::pluck('id')->toArray();
        $makes = VehicleMake::pluck('id')->toArray();
        $models = VehicleModel::pluck('id')->toArray();

        foreach ($vehicles as $vehicle) {
            VehicleRelation::updateOrCreate(
                ['vehicle_id' => $vehicle->id],
                [
                    'feature_id' => fake()->randomElement($features),
                    'make_id' => fake()->randomElement($makes),
                    'model_id' => fake()->randomElement($models),
                ]
            );
        }
    }
}
