<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // Entrepôts principaux
        $warehouse1 = Location::create([
            'name' => 'Entrepôt Principal',
            'description' => 'Entrepôt principal de stockage',
            'type' => 'warehouse',
            'is_active' => true
        ]);

        $warehouse2 = Location::create([
            'name' => 'Entrepôt Secondaire',
            'description' => 'Entrepôt pour le surplus',
            'type' => 'warehouse',
            'is_active' => true
        ]);

        // Zones dans l'entrepôt principal
        $zone1 = Location::create([
            'name' => 'Zone A',
            'description' => 'Zone des produits alimentaires',
            'type' => 'zone',
            'parent_id' => $warehouse1->id,
            'is_active' => true
        ]);

        $zone2 = Location::create([
            'name' => 'Zone B',
            'description' => 'Zone des produits électroniques',
            'type' => 'zone',
            'parent_id' => $warehouse1->id,
            'is_active' => true
        ]);

        // Étagères dans la Zone A
        for ($i = 1; $i <= 5; $i++) {
            $shelf = Location::create([
                'name' => "Étagère A{$i}",
                'description' => "Étagère {$i} de la zone A",
                'type' => 'shelf',
                'parent_id' => $zone1->id,
                'is_active' => true
            ]);

            // Boîtes sur chaque étagère
            for ($j = 1; $j <= 3; $j++) {
                Location::create([
                    'name' => "Boîte A{$i}-{$j}",
                    'description' => "Boîte {$j} de l'étagère A{$i}",
                    'type' => 'box',
                    'parent_id' => $shelf->id,
                    'is_active' => true
                ]);
            }
        }

        // Étagères dans la Zone B
        for ($i = 1; $i <= 3; $i++) {
            Location::create([
                'name' => "Étagère B{$i}",
                'description' => "Étagère {$i} de la zone B",
                'type' => 'shelf',
                'parent_id' => $zone2->id,
                'is_active' => true
            ]);
        }

        // Salle spéciale
        Location::create([
            'name' => 'Chambre Froide',
            'description' => 'Stockage des produits périssables',
            'type' => 'room',
            'parent_id' => $warehouse1->id,
            'is_active' => true
        ]);
    }
}
