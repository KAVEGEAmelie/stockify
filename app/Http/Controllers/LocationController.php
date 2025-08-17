<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('parent', 'children')
                            ->orderBy('parent_id')
                            ->orderBy('name')
                            ->paginate(20);

        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        $parentLocations = Location::whereNull('parent_id')->get();
        return view('locations.create', compact('parentLocations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:warehouse,shelf,box,room,zone',
            'parent_id' => 'nullable|exists:locations,id',
            'is_active' => 'boolean'
        ]);

        Location::create($request->all());

        return redirect()->route('locations.index')
                        ->with('success', 'Emplacement créé avec succès.');
    }

    public function show(string $id)
    {
        $location = Location::with(['parent', 'children', 'products'])->findOrFail($id);
        return view('locations.show', compact('location'));
    }

    public function edit(string $id)
    {
        $location = Location::findOrFail($id);
        $parentLocations = Location::where('id', '!=', $location->id)
                                  ->whereNull('parent_id')
                                  ->get();
        return view('locations.edit', compact('location', 'parentLocations'));
    }

    public function update(Request $request, string $id)
    {
        $location = Location::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:warehouse,shelf,box,room,zone',
            'parent_id' => [
                'nullable',
                'exists:locations,id',
                Rule::notIn([$location->id]) // Empêcher l'auto-référence
            ],
            'is_active' => 'boolean'
        ]);

        $location->update($request->all());

        return redirect()->route('locations.index')
                        ->with('success', 'Emplacement mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        
        if ($location->products()->count() > 0) {
            return redirect()->route('locations.index')
                           ->with('error', 'Impossible de supprimer un emplacement contenant des produits.');
        }

        if ($location->children()->count() > 0) {
            return redirect()->route('locations.index')
                           ->with('error', 'Impossible de supprimer un emplacement ayant des sous-emplacements.');
        }

        $location->delete();

        return redirect()->route('locations.index')
                        ->with('success', 'Emplacement supprimé avec succès.');
    }

    // API pour obtenir les emplacements hiérarchiques
    public function hierarchy()
    {
        $locations = Location::with('children')->whereNull('parent_id')->get();
        return response()->json($locations);
    }
}
