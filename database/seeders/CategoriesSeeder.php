<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Accident'],
            ['name' => 'Vol'],
            ['name' => 'Incendie'],
            ['name' => 'Agression'],
            ['name' => 'Panne'],
            ['name' => 'Dégradation'],
            ['name' => 'Danger Public'],
        ]);
    }
}
