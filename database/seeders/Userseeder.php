<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@oniontrade.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('secret123'),
                'role' => 'admin',
                'plan' => 'pro',
            ]
        );

        User::firstOrCreate(
            ['email' => 'viewer@oniontrade.com'],
            [
                'name' => 'Viewer',
                'password' => Hash::make('secret123'),
                'role' => 'viewer',
                'plan' => 'free',
            ]
        );
    }
}