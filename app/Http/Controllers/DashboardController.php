<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();

        // Compte les produits dont la quantité est inférieure ou égale au seuil d'alerte
        $lowStockProductsCount = Product::where('stock_quantity', '<=', DB::raw('min_stock_level'))->count();

        // Récupère les 5 derniers mouvements
        $recentMovements = StockMovement::with('product')->latest()->take(5)->get();

        return view('dashboard.index', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'lowStockProducts' => $lowStockProductsCount,
            'recentMovements' => $recentMovements,
            // 'lowStockItems' et 'user' ne sont pas encore gérés, nous les laissons pour plus tard
        ]);
    }
}
