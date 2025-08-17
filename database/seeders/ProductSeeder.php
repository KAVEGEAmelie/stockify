<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        if ($categories->isEmpty() || $suppliers->isEmpty()) {
            $this->command->info('Aucune catégorie ou fournisseur trouvé. Veuillez d\'abord exécuter leurs seeders.');
            return;
        }

        $products = [
            [
                'name' => 'Smartphone Samsung Galaxy A54',
                'description' => 'Smartphone Android avec écran 6.4" et 128GB de stockage',
                'sku' => 'SAMS-A54-128',
                'price' => 285000,
                'cost_price' => 220000,
                'stock_quantity' => 0,
                'min_stock_level' => 5,
            ],
            [
                'name' => 'iPhone 14 128GB',
                'description' => 'iPhone 14 avec 128GB de stockage et appareil photo 12MP',
                'sku' => 'APPL-IP14-128',
                'price' => 650000,
                'cost_price' => 520000,
                'stock_quantity' => 0,
                'min_stock_level' => 3,
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'MacBook Air avec puce M2, 8GB RAM et 256GB SSD',
                'sku' => 'APPL-MBA-M2-256',
                'price' => 950000,
                'cost_price' => 750000,
                'stock_quantity' => 0,
                'min_stock_level' => 2,
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Ultrabook Dell XPS 13 avec Intel i7 et 16GB RAM',
                'sku' => 'DELL-XPS13-I7',
                'price' => 850000,
                'cost_price' => 650000,
                'stock_quantity' => 0,
                'min_stock_level' => 2,
            ],
            [
                'name' => 'Casque Sony WH-1000XM4',
                'description' => 'Casque sans fil avec réduction de bruit active',
                'sku' => 'SONY-WH1000XM4',
                'price' => 165000,
                'cost_price' => 120000,
                'stock_quantity' => 0,
                'min_stock_level' => 10,
            ],
            [
                'name' => 'Tablette iPad Air',
                'description' => 'iPad Air 64GB avec écran 10.9 pouces',
                'sku' => 'APPL-IPAD-AIR-64',
                'price' => 420000,
                'cost_price' => 320000,
                'stock_quantity' => 0,
                'min_stock_level' => 5,
            ],
            [
                'name' => 'Clavier Logitech MX Keys',
                'description' => 'Clavier sans fil rétroéclairé pour Mac et PC',
                'sku' => 'LOGI-MXKEYS',
                'price' => 65000,
                'cost_price' => 45000,
                'stock_quantity' => 0,
                'min_stock_level' => 15,
            ],
            [
                'name' => 'Souris Logitech MX Master 3',
                'description' => 'Souris sans fil ergonomique pour productivité',
                'sku' => 'LOGI-MX3',
                'price' => 55000,
                'cost_price' => 38000,
                'stock_quantity' => 0,
                'min_stock_level' => 20,
            ],
        ];

        foreach ($products as $productData) {
            Product::create([
                ...$productData,
                'category_id' => $categories->random()->id,
                'supplier_id' => $suppliers->random()->id,
            ]);
        }

        $this->command->info('Produits créés avec succès !');
    }
}
