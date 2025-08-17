<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques de base
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalLocations = Location::count();

        // Compte les produits dont la quantité est inférieure ou égale au seuil d'alerte
        $lowStockProductsCount = Product::where('stock_quantity', '<=', DB::raw('COALESCE(alert_threshold, min_stock_level)'))->count();
        
        // Valeur totale du stock
        $totalStockValue = Product::sum(DB::raw('stock_quantity * cost_price'));

        // Récupère les 5 derniers mouvements
        $recentMovements = StockMovement::with('product')->latest()->take(5)->get();

        // Produits en stock critique (quantité = 0)
        $criticalStockCount = Product::where('stock_quantity', 0)->count();

        // Top 5 des produits les plus valorisés
        $topValuedProducts = Product::select('*', DB::raw('stock_quantity * cost_price as total_value'))
                                   ->orderByDesc('total_value')
                                   ->take(5)
                                   ->get();

        // Mouvements par jour (7 derniers jours)
        $movementsChart = StockMovement::select(
                            DB::raw('DATE(created_at) as date'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->where('created_at', '>=', Carbon::now()->subDays(7))
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();

        // Répartition par catégorie
        $categoryDistribution = Category::withCount('products')->get();

        // Raccourcis d'actions
        $quickActions = [
            [
                'title' => 'Ajouter un Produit',
                'url' => route('products.create'),
                'icon' => 'bi-plus-circle',
                'color' => 'success'
            ],
            [
                'title' => 'Mouvement de Stock',
                'url' => route('stock-movements.create'),
                'icon' => 'bi-arrow-left-right',
                'color' => 'primary'
            ],
            [
                'title' => 'Inventaire',
                'url' => route('inventory.count'),
                'icon' => 'bi-clipboard-check',
                'color' => 'info'
            ],
            [
                'title' => 'Rapports',
                'url' => route('reports.index'),
                'icon' => 'bi-file-earmark-bar-graph',
                'color' => 'warning'
            ]
        ];

        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'totalLocations' => $totalLocations,
            'lowStockCount' => $lowStockProductsCount,
            'criticalStockCount' => $criticalStockCount,
            'totalStockValue' => $totalStockValue,
            'recentMovements' => $recentMovements,
            'topValuedProducts' => $topValuedProducts,
            'movementsChart' => $movementsChart,
            'categoryDistribution' => $categoryDistribution,
            'quickActions' => $quickActions,
            'totalInStock' => $totalProducts - $criticalStockCount,
            'lowStockProducts' => Product::where('stock_quantity', '<=', DB::raw('COALESCE(alert_threshold, min_stock_level)'))->take(5)->get()
        ]);
    }
}
