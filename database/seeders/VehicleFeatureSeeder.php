<?php

namespace Database\Seeders;

use App\Models\VehicleFeature;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class VehicleFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'Air Conditioning', 'icon' => 'fa-snowflake', 'category' => VehicleFeature::FEATURE_CATEGORY_COMFORT],
            ['name' => 'GPS Navigation', 'icon' => 'fa-map-marker-alt', 'category' => VehicleFeature::FEATURE_CATEGORY_ENTERTAINMENT],
            ['name' => 'Bluetooth', 'icon' => 'fa-bluetooth', 'category' => VehicleFeature::FEATURE_CATEGORY_ENTERTAINMENT],
            ['name' => 'Backup Camera', 'icon' => 'fa-camera', 'category' => VehicleFeature::FEATURE_CATEGORY_SAFETY],
            ['name' => 'Heated Seats', 'icon' => 'fa-fire', 'category' => VehicleFeature::FEATURE_CATEGORY_COMFORT],
            ['name' => 'Sunroof', 'icon' => 'fa-sun', 'category' => VehicleFeature::FEATURE_CATEGORY_COMFORT],
            ['name' => 'Cruise Control', 'icon' => 'fa-road', 'category' => VehicleFeature::FEATURE_CATEGORY_OTHER],
            ['name' => 'Alloy Wheels', 'icon' => 'fa-circle', 'category' => VehicleFeature::FEATURE_CATEGORY_OTHER],
            ['name' => 'Parking Sensors', 'icon' => 'fa-car', 'category' => VehicleFeature::FEATURE_CATEGORY_SAFETY],
            ['name' => 'Blind Spot Monitor', 'icon' => 'fa-eye', 'category' => VehicleFeature::FEATURE_CATEGORY_SAFETY],
        ];

        foreach ($features as $feature) {
            VehicleFeature::updateOrCreate(
                ['slug' => Str::slug($feature['name'])],
                [
                    'name' => $feature['name'],
                    'icon' => $feature['icon'],
                    'feature_category' => $feature['category']
                ]
            );
        }
    }
}
