<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::withCount('products')
                            ->paginate(20);
        
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')
                         ->with('success', 'Fournisseur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load(['products.category']);
        
        $products = $supplier->products()
                            ->with(['category', 'stockMovements'])
                            ->paginate(15);
        
        $stats = [
            'total_products' => $supplier->products()->count(),
            'active_products' => $supplier->products()->where('is_active', true)->count(),
            'total_stock_value' => $supplier->products()
                                           ->selectRaw('SUM(price * stock_quantity) as total')
                                           ->value('total') ?? 0,
            'recent_movements' => $supplier->products()
                                          ->with('stockMovements')
                                          ->get()
                                          ->pluck('stockMovements')
                                          ->flatten()
                                          ->sortByDesc('movement_date')
                                          ->take(10)
        ];
        
        return view('suppliers.show', compact('supplier', 'products', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.show', $supplier)
                         ->with('success', 'Fournisseur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Vérifier s'il y a des produits associés
        if ($supplier->products()->count() > 0) {
            return back()->withErrors(['error' => 'Impossible de supprimer ce fournisseur car il a des produits associés.']);
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
                         ->with('success', 'Fournisseur supprimé avec succès.');
    }

    /**
     * Search suppliers
     */
    public function search(Request $request)
    {
        $query = Supplier::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_person', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('active')) {
            $query->where('is_active', $request->active);
        }

        $suppliers = $query->withCount('products')->paginate(20);

        return response()->json($suppliers);
    }

    /**
     * Export suppliers
     */
    public function export()
    {
        $suppliers = Supplier::with('products')->get();
        
        $filename = 'fournisseurs-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($suppliers) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'Nom',
                'Email',
                'Téléphone',
                'Adresse',
                'Personne de Contact',
                'Statut',
                'Nombre de Produits',
                'Date de Création'
            ]);
            
            // Data
            foreach ($suppliers as $supplier) {
                fputcsv($file, [
                    $supplier->name,
                    $supplier->email,
                    $supplier->phone,
                    $supplier->address,
                    $supplier->contact_person,
                    $supplier->is_active ? 'Actif' : 'Inactif',
                    $supplier->products->count(),
                    $supplier->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
