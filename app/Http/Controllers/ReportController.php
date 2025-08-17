<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function stockValuation()
    {
        $totalValue = Product::sum(DB::raw('stock_quantity * cost_price'));
        $totalProducts = Product::sum('stock_quantity');
        
        $categories = Category::with('products')
                             ->get()
                             ->map(function ($category) use ($totalValue) {
                                 $categoryValue = $category->products->sum(function($product) {
                                     return $product->stock_quantity * $product->cost_price;
                                 });
                                 $categoryQuantity = $category->products->sum('stock_quantity');
                                 
                                 return [
                                     'name' => $category->name,
                                     'value' => $categoryValue,
                                     'quantity' => $categoryQuantity,
                                     'percentage' => $totalValue > 0 ? ($categoryValue / $totalValue) * 100 : 0
                                 ];
                             })
                             ->sortByDesc('value');

        $topProducts = Product::select('*', DB::raw('stock_quantity * cost_price as value'))
                             ->orderByDesc('value')
                             ->take(10)
                             ->get();

        return view('reports.stock-valuation', compact(
            'totalValue', 
            'totalProducts', 
            'categories', 
            'topProducts'
        ));
    }

    public function stockRotation(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = Carbon::now()->subDays($days);

        // Produits avec mouvements
        $productsWithMovements = Product::select('products.*')
                                      ->addSelect(DB::raw('
                                          (SELECT COUNT(*) FROM stock_movements 
                                           WHERE stock_movements.product_id = products.id 
                                           AND stock_movements.created_at >= ?) as movement_count
                                      '), [$startDate])
                                      ->addSelect(DB::raw('
                                          (SELECT SUM(quantity) FROM stock_movements 
                                           WHERE stock_movements.product_id = products.id 
                                           AND stock_movements.direction = "out"
                                           AND stock_movements.created_at >= ?) as total_out
                                      '), [$startDate])
                                      ->having('movement_count', '>', 0)
                                      ->orderByDesc('movement_count')
                                      ->get();

        // Produits sans mouvements (dormants)
        $dormantProducts = Product::select('products.*')
                                 ->leftJoin('stock_movements', 'products.id', '=', 'stock_movements.product_id')
                                 ->whereNull('stock_movements.id')
                                 ->orWhere('stock_movements.created_at', '<', $startDate)
                                 ->groupBy('products.id')
                                 ->get();

        return view('reports.stock-rotation', compact(
            'productsWithMovements', 
            'dormantProducts', 
            'days'
        ));
    }

    public function lowStock()
    {
        $lowStockProducts = Product::lowStock()
                                  ->with(['category', 'supplier'])
                                  ->get()
                                  ->map(function($product) {
                                      $threshold = $product->alert_threshold ?? $product->min_stock_level;
                                      return [
                                          'product' => $product,
                                          'deficit' => $threshold - $product->stock_quantity,
                                          'urgency' => $product->stock_quantity == 0 ? 'critical' : 'warning'
                                      ];
                                  })
                                  ->sortBy('product.stock_quantity');

        $criticalCount = $lowStockProducts->where('urgency', 'critical')->count();
        $warningCount = $lowStockProducts->where('urgency', 'warning')->count();

        return view('reports.low-stock', compact(
            'lowStockProducts', 
            'criticalCount', 
            'warningCount'
        ));
    }

    // Export des rapports en PDF/CSV
    public function exportStockValuation(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        if ($format === 'csv') {
            return $this->exportStockValuationCsv();
        }
        
        // TODO: Implémenter l'export PDF
        return redirect()->back()->with('error', 'Format d\'export non supporté');
    }

    private function exportStockValuationCsv()
    {
        $products = Product::with('category')->get();
        
        $filename = 'valorisation_stock_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'SKU',
                'Nom',
                'Catégorie',
                'Quantité en Stock',
                'Prix d\'Achat',
                'Valeur Totale'
            ]);

            // Données
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->sku,
                    $product->name,
                    $product->category->name ?? 'N/A',
                    $product->stock_quantity,
                    $product->cost_price,
                    $product->stock_quantity * $product->cost_price
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
