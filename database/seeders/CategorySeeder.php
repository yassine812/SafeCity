<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Déchets et propreté',
                'description' => 'Problèmes liés aux déchets, ordures et propreté des espaces publics',
                'icon' => 'trash',
                'color' => '#4CAF50',
                'order' => 1,
            ],
            [
                'name' => 'Voirie',
                'description' => 'Problèmes de chaussée, trottoirs, éclairage public et signalisation',
                'icon' => 'road',
                'color' => '#2196F3',
                'order' => 2,
            ],
            [
                'name' => 'Espaces verts',
                'description' => 'Entretien des parcs, jardins et espaces verts',
                'icon' => 'tree',
                'color' => '#8BC34A',
                'order' => 3,
            ],
            [
                'name' => 'Sécurité',
                'description' => 'Problèmes de sécurité publique, éclairage défaillant, etc.',
                'icon' => 'shield',
                'color' => '#F44336',
                'order' => 4,
            ],
            [
                'name' => 'Stationnement',
                'description' => 'Problèmes de stationnement illicite ou de places dédiées',
                'icon' => 'parking',
                'color' => '#9C27B0',
                'order' => 5,
            ],
            [
                'name' => 'Autre',
                'description' => 'Autres types de problèmes non catégorisés',
                'icon' => 'ellipsis-h',
                'color' => '#9E9E9E',
                'order' => 99,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                array_merge($category, [
                    'slug' => Str::slug($category['name']),
                    'is_active' => true,
                ])
            );
        }
    }
}
