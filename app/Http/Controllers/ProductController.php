<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Affiche une liste paginée de tous les produits.
     * Utilise l'eager loading pour optimiser les requêtes.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('products.index', compact('products'));
    }

    /**
     * Affiche le formulaire pour créer un nouvel article.
     * Fournit toutes les données nécessaires pour les listes déroulantes.
     */
    public function create()
    {
        $product = new Product(); // Objet vide pour la compatibilité du formulaire partiel
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('products.create', compact('product', 'categories', 'suppliers', 'tags'));
    }

    /**
     * Enregistre un nouvel article dans la base de données.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules());

        // Gère le champ 'is_active' qui n'est pas envoyé si décoché
        $validatedData['is_active'] = $request->has('is_active');

        $product = Product::create($validatedData);

        // Synchronise les tags (relation Many-to-Many)
        if ($request->has('tags')) {
            $product->tags()->sync($request->tags);
        }

        return redirect()->route('products.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Affiche la page de détail d'un article spécifique.
     */
    public function show(Product $product)
    {
        $product->load('category', 'supplier', 'tags', 'locations', 'stockMovements');
        return view('products.show', compact('product'));
    }

    /**
     * Affiche le formulaire pour modifier un article existant.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories', 'suppliers', 'tags'));
    }

    /**
     * Met à jour un article dans la base de données.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate($this->validationRules($product->id));
        $validatedData['is_active'] = $request->has('is_active');

        $product->update($validatedData);

        // Synchronise les tags, en les retirant tous si aucun n'est sélectionné
        $product->tags()->sync($request->input('tags', []));

        return redirect()->route('products.index')->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Supprime un article de la base de données.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Article supprimé avec succès.');
    }

    /**
     * Règles de validation centralisées pour `store` et `update`.
     * @param int|null $productId L'ID du produit à ignorer pour la règle 'unique'
     * @return array
     */
    protected function validationRules($productId = null)
    {
        $skuRule = 'required|string|max:255|unique:products,sku';
        if ($productId) {
            $skuRule .= ',' . $productId; // Ignore l'ID actuel lors de la mise à jour
        }

        return [
            'name' => 'required|string|max:255',
            'sku' => $skuRule,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
