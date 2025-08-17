<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Smartphones',
                'description' => 'Téléphones mobiles et smartphones'
            ],
            [
                'name' => 'Ordinateurs',
                'description' => 'Ordinateurs portables et de bureau'
            ],
            [
                'name' => 'Tablettes',
                'description' => 'Tablettes et liseuses électroniques'
            ],
            [
                'name' => 'Accessoires',
                'description' => 'Accessoires informatiques et téléphonie'
            ],
            [
                'name' => 'Audio',
                'description' => 'Casques, écouteurs et enceintes'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Catégories créées avec succès !');
    }
}
