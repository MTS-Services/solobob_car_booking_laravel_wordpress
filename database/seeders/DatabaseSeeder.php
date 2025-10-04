<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => Hash::make('admin@dev.com'),
            'email_verified_at' => now(),
            'is_admin' => User::ROLE_ADMIN,
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@dev.com',
            'password' => Hash::make('user@dev.com'),
            'email_verified_at' => now(),
        ]);
        // User::factory(50)->create();

        $this->call([
            CategorySeeder::class,
            VehicleMakeSeeder::class,
            VehicleModelSeeder::class,
            VehicleFuelSeeder::class,
            VehicleFeatureSeeder::class,
            VehicleImageSeeder::class,
            VehicleRelationSeeder::class,
            VehicleLocationSeeder::class,
            VehicleAvailabilitySeeder::class,
        ]);
    }
}
