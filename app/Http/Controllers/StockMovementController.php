<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    /**
     * Affiche l'historique de tous les mouvements de stock.
     */
    public function index()
    {
        $movements = StockMovement::with(['product', 'user'])
            ->latest('movement_date')
            ->paginate(20);

        // Calcul des statistiques
        $stats = [
            'entriesCount' => StockMovement::where('type', 'in')->count(),
            'exitsCount' => StockMovement::where('type', 'out')->count(),
            'totalQuantity' => StockMovement::sum('quantity'),
            'todayMovements' => StockMovement::whereDate('movement_date', today())->count(),
        ];

        return view('stock_movements.index', compact('movements', 'stats'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau mouvement (entrée ou sortie) pour un produit spécifique.
     */
    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
        ]);

        $product = Product::findOrFail($request->product_id);
        $type = $request->type;

        return view('stock_movements.create', compact('product', 'type'));
    }

    /**
     * Enregistre le mouvement et met à jour le stock du produit de manière atomique.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'movement_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $type = $request->type;

        try {
            DB::transaction(function () use ($product, $type, $quantity, $request) {
                // 1. Verrouille la ligne du produit pour éviter les conditions de concurrence (race conditions)
                $product = Product::where('id', $product->id)->lockForUpdate()->first();

                $previous_stock = $product->stock_quantity;

                if ($type === 'out' && $quantity > $previous_stock) {
                    // Lance une exception de validation si le stock est insuffisant
                    throw ValidationException::withMessages([
                        'quantity' => 'La quantité à retirer est supérieure au stock disponible ('.$previous_stock.').'
                    ]);
                }

                // 2. Calcule le nouveau stock
                $new_stock = ($type === 'in')
                    ? $previous_stock + $quantity
                    : $previous_stock - $quantity;

                // 3. Met à jour le stock du produit
                $product->update(['stock_quantity' => $new_stock]);

                // 4. Crée l'enregistrement du mouvement de stock
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(), // Assurez-vous que l'authentification est en place
                    'type' => $type,
                    'quantity' => $quantity,
                    'previous_stock' => $previous_stock,
                    'new_stock' => $new_stock,
                    'notes' => $request->notes,
                    'movement_date' => $request->movement_date,
                ]);
            });

        } catch (ValidationException $e) {
            // Redirige en arrière avec les erreurs de validation
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('products.show', $product)->with('success', 'Mouvement de stock enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        $stockMovement->load(['product.category', 'user']);
        
        return view('stock_movements.show', compact('stockMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        $stockMovement->load(['product.category', 'user']);
        
        return view('stock_movements.edit', compact('stockMovement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        $request->validate([
            'movement_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $product = $stockMovement->product;
        $oldQuantity = $stockMovement->quantity;
        $newQuantity = $request->quantity;
        
        // Recalculer le stock en tenant compte du changement de quantité
        if ($stockMovement->type === 'in') {
            // Pour une entrée: soustraire l'ancien mouvement et ajouter le nouveau
            $newStock = $product->stock_quantity - $oldQuantity + $newQuantity;
        } else {
            // Pour une sortie: ajouter l'ancien mouvement et soustraire le nouveau
            $newStock = $product->stock_quantity + $oldQuantity - $newQuantity;
        }

        // Vérifier que le stock ne devient pas négatif
        if ($newStock < 0) {
            return back()->withErrors(['quantity' => 'Cette modification rendrait le stock négatif.']);
        }

        // Transaction pour assurer la cohérence
        DB::transaction(function () use ($stockMovement, $request, $product, $newStock, $newQuantity) {
            // Mettre à jour le mouvement
            $stockMovement->update([
                'movement_date' => $request->movement_date,
                'quantity' => $newQuantity,
                'reference' => $request->reference,
                'notes' => $request->notes,
                'new_stock' => $newStock,
            ]);

            // Mettre à jour le stock du produit
            $product->update(['stock_quantity' => $newStock]);
        });

        return redirect()->route('stock-movements.show', $stockMovement)
                         ->with('success', 'Mouvement de stock modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        $product = $stockMovement->product;
        
        // Vérifier si la suppression est autorisée
        // On ne peut supprimer que si ce n'est pas le dernier mouvement qui a affecté le stock
        $lastMovement = $product->stockMovements()->latest('movement_date')->first();
        
        if ($lastMovement && $lastMovement->id !== $stockMovement->id) {
            return back()->withErrors(['error' => 'Seuls les derniers mouvements peuvent être supprimés pour maintenir la cohérence du stock.']);
        }

        // Transaction pour assurer la cohérence
        DB::transaction(function () use ($stockMovement, $product) {
            // Restaurer le stock précédent
            $product->update(['stock_quantity' => $stockMovement->previous_stock]);
            
            // Supprimer le mouvement
            $stockMovement->delete();
        });

        return redirect()->route('stock-movements.index')
                         ->with('success', 'Mouvement de stock supprimé avec succès.');
    }

    /**
     * Export des mouvements pour un produit spécifique
     */
    public function export(Product $product)
    {
        $movements = $product->stockMovements()->with('user')->latest('movement_date')->get();
        
        $filename = 'mouvements_' . $product->sku . '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($movements) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Date',
                'Type',
                'Quantité',
                'Stock Avant',
                'Stock Après',
                'Utilisateur',
                'Notes'
            ]);

            // Données
            foreach ($movements as $movement) {
                fputcsv($file, [
                    $movement->movement_date->format('Y-m-d H:i:s'),
                    $movement->type === 'in' ? 'Entrée' : 'Sortie',
                    $movement->quantity,
                    $movement->previous_stock,
                    $movement->new_stock,
                    $movement->user->name ?? 'Système',
                    $movement->notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * API pour rechercher les mouvements
     */
    public function search(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->date) {
            $query->whereDate('movement_date', $request->date);
        }

        if ($request->product) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product . '%')
                  ->orWhere('sku', 'like', '%' . $request->product . '%');
            });
        }

        $movements = $query->latest('movement_date')->paginate(20);

        return response()->json($movements);
    }
}
