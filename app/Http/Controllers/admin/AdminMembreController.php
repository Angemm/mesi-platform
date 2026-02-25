<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Membre, Departement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMembreController extends Controller
{
    public function index(Request $request)
    {
        $query = Membre::with('departement');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('prenom', 'like', "%{$q}%")
                   ->orWhere('nom',   'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('departement')) {
            $query->where('departement_id', $request->departement);
        }

        $membres = $query->orderBy('prenom')->paginate(20)->withQueryString();

        // Chiffres rapides pour les cards
        $actifs      = Membre::where('statut', 'actif')->count();
        $departements= Departement::count();
        $dirigeants  = Membre::where('est_dirigeant', true)->count();

        return view('admin.membres.index', compact('membres', 'actifs', 'departements', 'dirigeants'));
    }

    public function create()
    {
        return view('admin.membres.form');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['est_dirigeant']  = $request->boolean('est_dirigeant');
        $validated['visible_public'] = $request->boolean('visible_public');

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('membres', 'public');
        }

        Membre::create($validated);

        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre ajouté avec succès.');
    }

    public function edit(Membre $membre)
    {
        return view('admin.membres.form', compact('membre'));
    }

    public function update(Request $request, Membre $membre)
    {
        $validated = $this->validateRequest($request);
        $validated['est_dirigeant']  = $request->boolean('est_dirigeant');
        $validated['visible_public'] = $request->boolean('visible_public');

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($membre->photo ?? '');
            $validated['photo'] = $request->file('photo')->store('membres', 'public');
        }

        $membre->update($validated);

        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre mis à jour.');
    }

    public function destroy(Membre $membre)
    {
        Storage::disk('public')->delete($membre->photo ?? '');
        $membre->delete();

        return back()->with('success', 'Membre supprimé.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'prenom'           => 'required|string|max:100',
            'nom'              => 'required|string|max:100',
            'email'            => 'nullable|email|max:150',
            'telephone'        => 'nullable|string|max:20',
            'adresse'          => 'nullable|string|max:250',
            'date_naissance'   => 'nullable|date',
            'sexe'             => 'nullable|in:M,F',
            'role_eglise'      => 'nullable|string|max:100',
            'departement_id'   => 'nullable|exists:departements,id',
            'statut'           => 'required|in:actif,inactif,visiteur',
            'date_integration' => 'nullable|date',
            'citation'         => 'nullable|string|max:500',
            'ordre'            => 'nullable|integer',
            'photo'            => 'nullable|image|max:2048',
        ]);
    }
}
