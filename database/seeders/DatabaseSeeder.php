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
        // Création d'un administrateur par défaut
        User::updateOrCreate(
            ['email' => 'admin@safecity.dz'],
            [
                'name' => 'Administrateur',
                'email' => 'admin@safecity.dz',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        // Exécution des seeders
        $this->call([
            StatusSeeder::class, // Doit être exécuté avant CategorySeeder
            CategorySeeder::class,
            // Ajoutez d'autres seeders ici si nécessaire
        ]);
    }
}
