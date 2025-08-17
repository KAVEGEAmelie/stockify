<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Carbon\Carbon;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $products = Product::all();

        if ($products->isEmpty() || !$user) {
            $this->command->info('Aucun produit ou utilisateur trouvé. Veuillez d\'abord exécuter les seeders des produits et utilisateurs.');
            return;
        }

        foreach ($products as $product) {
            // Stock initial (entrée)
            $initialStock = rand(50, 200);
            
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $initialStock,
                'previous_stock' => 0,
                'new_stock' => $initialStock,
                'reference' => 'INIT-' . $product->sku,
                'notes' => 'Stock initial du produit',
                'user_id' => $user->id,
                'movement_date' => Carbon::now()->subDays(30),
            ]);

            // Mettre à jour le stock du produit
            $product->update(['stock_quantity' => $initialStock]);
            $currentStock = $initialStock;

            // Générer quelques mouvements aléatoires
            for ($i = 0; $i < rand(3, 8); $i++) {
                $isEntry = rand(0, 1);
                $quantity = rand(5, 50);
                
                if ($isEntry) {
                    // Entrée de stock
                    $previousStock = $currentStock;
                    $newStock = $currentStock + $quantity;
                    
                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => 'in',
                        'quantity' => $quantity,
                        'previous_stock' => $previousStock,
                        'new_stock' => $newStock,
                        'reference' => 'REF-' . rand(1000, 9999),
                        'notes' => 'Réapprovisionnement du stock',
                        'user_id' => $user->id,
                        'movement_date' => Carbon::now()->subDays(rand(1, 25)),
                    ]);
                } else {
                    // Sortie de stock (seulement si on a du stock)
                    if ($currentStock >= $quantity) {
                        $previousStock = $currentStock;
                        $newStock = $currentStock - $quantity;
                        
                        StockMovement::create([
                            'product_id' => $product->id,
                            'type' => 'out',
                            'quantity' => $quantity,
                            'previous_stock' => $previousStock,
                            'new_stock' => $newStock,
                            'reference' => 'VENTE-' . rand(1000, 9999),
                            'notes' => 'Vente de produits',
                            'user_id' => $user->id,
                            'movement_date' => Carbon::now()->subDays(rand(1, 25)),
                        ]);
                        
                        $newStock = $currentStock - $quantity;
                    } else {
                        // Si pas assez de stock, on fait une entrée à la place
                        $previousStock = $currentStock;
                        $newStock = $currentStock + $quantity;
                        
                        StockMovement::create([
                            'product_id' => $product->id,
                            'type' => 'in',
                            'quantity' => $quantity,
                            'previous_stock' => $previousStock,
                            'new_stock' => $newStock,
                            'reference' => 'REF-' . rand(1000, 9999),
                            'notes' => 'Réapprovisionnement automatique',
                            'user_id' => $user->id,
                            'movement_date' => Carbon::now()->subDays(rand(1, 25)),
                        ]);
                    }
                }
                
                $currentStock = $newStock;
            }

            // Mettre à jour le stock final du produit
            $product->update(['stock_quantity' => $currentStock]);
        }

        $this->command->info('Stock movements créés avec succès !');
    }
}
