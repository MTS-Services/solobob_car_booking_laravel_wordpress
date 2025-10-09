<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => Hash::make('admin@dev.com'),
            'email_verified_at' => now(),
            'is_admin' => User::ROLE_ADMIN,
        ]);

        // Normal test user
        User::create([
            'name' => 'User',
            'email' => 'user@dev.com',
            'password' => Hash::make('user@dev.com'),
            'email_verified_at' => now(),
        ]);

        User::factory()->count(20)->create();
    }
}
