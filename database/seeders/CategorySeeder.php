<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Sedan',
            'SUV',
            'Hatchback',
            'Coupe',
            'Convertible',
            'Pickup Truck',
            'Crossover',
            'Minivan',
            'Electric Vehicle',
            'Hybrid Vehicle',
            'Luxury Car',
            'Sports Car',
            'Diesel Vehicle',
            'Compact Car',
            'Off-Road Vehicle',
            'Classic Car',
            'Commercial Vehicle',
            'Motorcycle',
            'Truck',
            'Van'
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'status' => Category::STATUS_ACTIVE,
                ]
            );
        }
    }
}
