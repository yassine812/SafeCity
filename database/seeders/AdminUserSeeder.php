<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Autorité Centrale',
            'email' => 'autorite@safecity.dz',
            'password' => bcrypt('password'),
            'role' => 'autorite',
            'email_verified_at' => now(),
        ]);
    }
}
