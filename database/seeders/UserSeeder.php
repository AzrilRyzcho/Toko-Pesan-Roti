<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@tokopesanroti.com'],
            [
                'name' => 'Administrator Roti',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Bakery Indah No. 1, Jakarta',
            ]
        );

        // Customer
        User::updateOrCreate(
            ['email' => 'customer@tokopesanroti.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '087766554433',
                'address' => 'Jl. Kenari No. 12, Bandung',
            ]
        );
    }
}
