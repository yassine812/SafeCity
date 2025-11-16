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
        // Exécution des seeders
        $this->call([
            StatusSeeder::class,    // Doit être exécuté avant CategorySeeder
            CategorySeeder::class,  // Seed les catégories
            AdminUserSeeder::class, // Seed l'utilisateur admin
        ]);
    }
}
