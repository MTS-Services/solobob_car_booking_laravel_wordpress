<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{
    Vehicle,
    Category,
    User
};

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Ensure you have some users and categories first
        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        if (empty($users) || empty($categories)) {
            $this->command->warn('⚠️ Skipping VehicleSeeder — no users or categories found.');
            return;
        }

        $vehicles = [
            [
                'title' => 'Toyota Corolla 2021',
                'year' => 2021,
                'color' => 'White',
                'seating_capacity' => 5,
                'mileage' => 35000,
                'weekly_rate' => 300.00,
                'monthly_rate' => 1000.00,
                'security_deposit_weekly' => 150.00,
                'security_deposit_monthly' => 300.00,
                'instant_booking' => true,
                'delivery_available' => true,
                'delivery_fee' => 50.00,
                'transmission_type' => 1, // Example: 1 = Automatic
                'description' => 'A clean and reliable Toyota Corolla with excellent fuel economy.',
            ],
            [
                'title' => 'Honda Civic 2020',
                'year' => 2020,
                'color' => 'Black',
                'seating_capacity' => 5,
                'mileage' => 42000,
                'weekly_rate' => 320.00,
                'monthly_rate' => 1100.00,
                'security_deposit_weekly' => 160.00,
                'security_deposit_monthly' => 320.00,
                'instant_booking' => false,
                'delivery_available' => true,
                'delivery_fee' => 45.00,
                'transmission_type' => 1,
                'description' => 'Sporty design, smooth ride, and fuel-efficient engine.',
            ],
            [
                'title' => 'Tesla Model 3 2022',
                'year' => 2022,
                'color' => 'Red',
                'seating_capacity' => 5,
                'mileage' => 12000,
                'weekly_rate' => 600.00,
                'monthly_rate' => 2000.00,
                'security_deposit_weekly' => 250.00,
                'security_deposit_monthly' => 500.00,
                'instant_booking' => true,
                'delivery_available' => true,
                'delivery_fee' => 75.00,
                'transmission_type' => 1, // Electric - single speed
                'description' => 'Fully electric Tesla Model 3 with autopilot and premium interior.',
            ],
        ];

        foreach ($vehicles as $index => $data) {
            Vehicle::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'sort_order' => $index + 1,
                    'owner_id' => fake()->randomElement($users),
                    'category_id' => fake()->randomElement($categories),
                    'license_plate' => strtoupper(fake()->bothify('??-####')),
                    'status' => Vehicle::STATUS_AVAILABLE,
                ])
            );
        }
    }
}
