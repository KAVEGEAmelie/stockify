<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::lowStock()->count();
        $zeroStockCount = Product::where('stock_quantity', 0)->count();
        $totalValue = Product::sum(DB::raw('stock_quantity * cost_price'));

        $recentAdjustments = StockMovement::where('type', 'adjustment')
                                        ->with('product')
                                        ->latest()
                                        ->take(10)
                                        ->get();

        return view('inventory.index', compact(
            'totalProducts', 
            'lowStockCount', 
            'zeroStockCount', 
            'totalValue',
            'recentAdjustments'
        ));
    }

    public function count(Request $request)
    {
        $query = Product::with(['category', 'locations']);

        // Filtres
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->whereHas('locations', function($q) use ($request) {
                $q->where('location_id', $request->location);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhere('barcode', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->paginate(20);
        
        // Pour les filtres
        $categories = \App\Models\Category::all();
        $locations = Location::all();

        return view('inventory.count', compact('products', 'categories', 'locations'));
    }

    public function adjust(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'counted_quantity' => 'required|integer|min:0',
            'reason' => 'required|string|max:255'
        ]);

        $product = Product::findOrFail($request->product_id);
        $currentQuantity = $product->stock_quantity;
        $countedQuantity = $request->counted_quantity;
        $difference = $countedQuantity - $currentQuantity;

        if ($difference != 0) {
            // Créer un mouvement d'ajustement
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'adjustment',
                'quantity' => abs($difference),
                'direction' => $difference > 0 ? 'in' : 'out',
                'reason' => $request->reason,
                'reference' => 'ADJ-' . date('YmdHis'),
                'performed_by' => 'System' // À remplacer par l'utilisateur connecté
            ]);

            // Mettre à jour la quantité du produit
            $product->update(['stock_quantity' => $countedQuantity]);

            $message = $difference > 0 
                ? "Ajustement d'inventaire : +{$difference} unités ajoutées"
                : "Ajustement d'inventaire : " . abs($difference) . " unités retirées";

            return response()->json([
                'success' => true,
                'message' => $message,
                'new_quantity' => $countedQuantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Aucun ajustement nécessaire',
            'new_quantity' => $currentQuantity
        ]);
    }

    public function scan()
    {
        return view('inventory.scan');
    }

    // API pour scanner un code-barres
    public function findByBarcode(Request $request)
    {
        $barcode = $request->barcode;
        
        $product = Product::where('barcode', $barcode)
                         ->orWhere('sku', $barcode)
                         ->with(['category', 'locations'])
                         ->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'current_quantity' => $product->stock_quantity,
                    'category' => $product->category->name ?? 'N/A',
                    'locations' => $product->locations->pluck('name')->join(', ') ?: 'Aucun'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produit non trouvé'
        ]);
    }
}
