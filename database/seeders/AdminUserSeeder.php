<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if it doesn't exist
        User::updateOrCreate(
            ['email' => 'admin@safecity.dz'],
            [
                'name' => 'Administrateur',
                'email' => 'admin@safecity.dz',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
                'role' => 'admin',
            ]
        );
    }
}
