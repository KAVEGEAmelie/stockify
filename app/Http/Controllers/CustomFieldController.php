<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    public function index()
    {
        $customFields = CustomField::ordered()->paginate(20);
        return view('custom-fields.index', compact('customFields'));
    }

    public function create()
    {
        return view('custom-fields.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,textarea,select',
            'options' => 'nullable|array',
            'options.*' => 'string|max:255',
            'is_required' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Pour les champs de type select, on s'assure que les options sont définies
        if ($request->type === 'select' && $request->has('options')) {
            $data['options'] = array_filter($request->options); // Supprimer les options vides
        } else {
            $data['options'] = null;
        }

        // Si l'ordre n'est pas spécifié, on prend le prochain disponible
        if (!$request->filled('order')) {
            $data['order'] = CustomField::max('order') + 1;
        }

        CustomField::create($data);

        return redirect()->route('custom-fields.index')
                        ->with('success', 'Champ personnalisé créé avec succès.');
    }

    public function show(string $id)
    {
        $customField = CustomField::with('values.product')->findOrFail($id);
        return view('custom-fields.show', compact('customField'));
    }

    public function edit(string $id)
    {
        $customField = CustomField::findOrFail($id);
        return view('custom-fields.edit', compact('customField'));
    }

    public function update(Request $request, string $id)
    {
        $customField = CustomField::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,textarea,select',
            'options' => 'nullable|array',
            'options.*' => 'string|max:255',
            'is_required' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Pour les champs de type select
        if ($request->type === 'select' && $request->has('options')) {
            $data['options'] = array_filter($request->options);
        } else {
            $data['options'] = null;
        }

        $customField->update($data);

        return redirect()->route('custom-fields.index')
                        ->with('success', 'Champ personnalisé mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $customField = CustomField::findOrFail($id);
        
        // Vérifier si le champ est utilisé
        if ($customField->values()->count() > 0) {
            return redirect()->route('custom-fields.index')
                           ->with('error', 'Impossible de supprimer un champ personnalisé utilisé par des produits.');
        }

        $customField->delete();

        return redirect()->route('custom-fields.index')
                        ->with('success', 'Champ personnalisé supprimé avec succès.');
    }
}
