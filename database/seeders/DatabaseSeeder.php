<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@dentalease.com'],
            [
                'name' => 'Dental Ease Admin',
                'phone' => '0000000000',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'verification_status' => 'approved',
                'verified_at' => now(),
            ]
        );

        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'phone' => '09123456789',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'verification_status' => 'pending',
        ]);
    }
}
