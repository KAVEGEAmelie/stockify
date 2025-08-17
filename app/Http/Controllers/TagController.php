<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('products')->paginate(20);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'description' => 'nullable|string'
        ]);

        Tag::create($request->all());

        return redirect()->route('tags.index')
                        ->with('success', 'Tag créé avec succès.');
    }

    public function show(string $id)
    {
        $tag = Tag::with('products')->findOrFail($id);
        return view('tags.show', compact('tag'));
    }

    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, string $id)
    {
        $tag = Tag::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'description' => 'nullable|string'
        ]);

        $tag->update($request->all());

        return redirect()->route('tags.index')
                        ->with('success', 'Tag mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('tags.index')
                        ->with('success', 'Tag supprimé avec succès.');
    }

    // API pour la recherche de tags
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $tags = Tag::where('name', 'LIKE', "%{$query}%")
                   ->limit(10)
                   ->get(['id', 'name', 'color']);

        return response()->json($tags);
    }
}
