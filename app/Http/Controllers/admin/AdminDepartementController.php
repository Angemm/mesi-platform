<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;

class AdminDepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::withCount('membres')->orderBy('ordre')->get();
        return view('admin.departements.index', compact('departements'));
    }

    public function create()
    {
        return view('admin.departements.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:150',
            'description' => 'nullable|string',
            'responsable' => 'nullable|string|max:150',
            'icone'       => 'nullable|string|max:60',
            'ordre'       => 'nullable|integer',
        ]);

        Departement::create($validated);

        return redirect()->route('admin.departements.index')
            ->with('success', 'Département créé.');
    }

    public function edit(Departement $departement)
    {
        return view('admin.departements.form', compact('departement'));
    }

    public function update(Request $request, Departement $departement)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:150',
            'description' => 'nullable|string',
            'responsable' => 'nullable|string|max:150',
            'icone'       => 'nullable|string|max:60',
            'ordre'       => 'nullable|integer',
        ]);

        $departement->update($validated);

        return redirect()->route('admin.departements.index')
            ->with('success', 'Département mis à jour.');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();
        return back()->with('success', 'Département supprimé.');
    }
}
