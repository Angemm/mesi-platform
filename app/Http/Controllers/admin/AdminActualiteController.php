<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminActualiteController extends Controller
{
    public function index()
    {
        $actualites = Actualite::with('categorie')->orderByDesc('created_at')->paginate(15);
        return view('admin.actualites.index', compact('actualites'));
    }

    public function create()
    {
        $categories = \App\Models\CategorieActualite::all();
        return view('admin.actualites.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'       => 'required|string|max:200',
            'contenu'     => 'required|string',
            'extrait'     => 'nullable|string|max:300',
            'image'       => 'nullable|image|max:2048',
            'publie'      => 'boolean',
            'en_vedette'  => 'boolean',
            'categorie_id'=> 'nullable|exists:categorie_actualites,id',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('actualites', 'public');
        }
        $data['slug'] = \Str::slug($data['titre']) . '-' . now()->timestamp;
        $data['auteur_id'] = auth()->id();
        Actualite::create($data);
        return redirect()->route('admin.actualites.index')->with('success', 'Article publié !');
    }

    public function edit(Actualite $actualite)
    {
        $categories = \App\Models\CategorieActualite::all();
        return view('admin.actualites.form', compact('actualite', 'categories'));
    }

    public function update(Request $request, Actualite $actualite)
    {
        $data = $request->validate([
            'titre'       => 'required|string|max:200',
            'contenu'     => 'required|string',
            'extrait'     => 'nullable|string|max:300',
            'image'       => 'nullable|image|max:2048',
            'publie'      => 'boolean',
            'en_vedette'  => 'boolean',
            'categorie_id'=> 'nullable|exists:categorie_actualites,id',
        ]);
        if ($request->hasFile('image')) {
            if ($actualite->image) \Storage::disk('public')->delete($actualite->image);
            $data['image'] = $request->file('image')->store('actualites', 'public');
        }
        $actualite->update($data);
        return redirect()->route('admin.actualites.index')->with('success', 'Article mis à jour !');
    }

    public function destroy(Actualite $actualite)
    {
        if ($actualite->image) \Storage::disk('public')->delete($actualite->image);
        $actualite->delete();
        return back()->with('success', 'Article supprimé.');
    }
}
