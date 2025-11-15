<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Nouveau',
                'description' => 'Nouvel incident signalé',
                'color' => '#3B82F6', // blue-500
                'icon' => 'bell',
                'is_default' => true,
                'order' => 1,
            ],
            [
                'name' => 'En cours',
                'description' => 'Incident en cours de traitement',
                'color' => '#F59E0B', // amber-500
                'icon' => 'clock',
                'is_default' => false,
                'order' => 2,
            ],
            [
                'name' => 'En attente',
                'description' => 'En attente de plus d\'informations',
                'color' => '#6B7280', // gray-500
                'icon' => 'pause-circle',
                'is_default' => false,
                'order' => 3,
            ],
            [
                'name' => 'Résolu',
                'description' => 'Incident résolu',
                'color' => '#10B981', // emerald-500
                'icon' => 'check-circle',
                'is_default' => false,
                'order' => 4,
            ],
            [
                'name' => 'Fermé',
                'description' => 'Incident fermé',
                'color' => '#6B7280', // gray-500
                'icon' => 'lock-closed',
                'is_default' => false,
                'order' => 5,
            ],
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                ['name' => $status['name']],
                array_merge($status, [
                    'slug' => Str::slug($status['name']),
                ])
            );
        }
    }
}
