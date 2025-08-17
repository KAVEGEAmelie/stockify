<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Nouveau',
                'color' => '#28a745',
                'description' => 'Produits nouvellement ajoutés'
            ],
            [
                'name' => 'Promotion',
                'color' => '#dc3545',
                'description' => 'Produits en promotion'
            ],
            [
                'name' => 'Best Seller',
                'color' => '#ffc107',
                'description' => 'Produits les plus vendus'
            ],
            [
                'name' => 'Périssable',
                'color' => '#fd7e14',
                'description' => 'Produits avec date d\'expiration'
            ],
            [
                'name' => 'Fragile',
                'color' => '#e83e8c',
                'description' => 'Produits nécessitant une manipulation délicate'
            ],
            [
                'name' => 'Urgence',
                'color' => '#dc3545',
                'description' => 'Produits à traiter en priorité'
            ],
            [
                'name' => 'Saisonnier',
                'color' => '#17a2b8',
                'description' => 'Produits saisonniers'
            ],
            [
                'name' => 'Premium',
                'color' => '#6f42c1',
                'description' => 'Produits haut de gamme'
            ],
            [
                'name' => 'Défectueux',
                'color' => '#6c757d',
                'description' => 'Produits présentant des défauts'
            ],
            [
                'name' => 'Liquidation',
                'color' => '#fd7e14',
                'description' => 'Produits en liquidation'
            ]
        ];

        foreach ($tags as $tagData) {
            Tag::create($tagData);
        }
    }
}
