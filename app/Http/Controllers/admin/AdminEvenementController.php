<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEvenementController extends Controller
{
    public function index(Request $request)
    {
        $query = Evenement::query();

        if ($request->filled('q')) {
            $query->where('titre', 'like', '%'.$request->q.'%');
        }

        $evenements = $query->orderBy('date_debut')->paginate(15)->withQueryString();

        return view('admin.evenements.index', compact('evenements'));
    }

    public function create()
    {
        return view('admin.evenements.form');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('evenements', 'public');
        }

        Evenement::create($validated);

        return redirect()->route('admin.evenements.index')
            ->with('success', 'Événement créé avec succès.');
    }

    public function edit(Evenement $evenement)
    {
        return view('admin.evenements.form', compact('evenement'));
    }

    public function update(Request $request, Evenement $evenement)
    {
        $validated = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($evenement->image ?? '');
            $validated['image'] = $request->file('image')->store('evenements', 'public');
        }

        $evenement->update($validated);

        return redirect()->route('admin.evenements.index')
            ->with('success', 'Événement mis à jour.');
    }

    public function destroy(Evenement $evenement)
    {
        Storage::disk('public')->delete($evenement->image ?? '');
        $evenement->delete();

        return back()->with('success', 'Événement supprimé.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'titre'       => 'required|string|max:200',
            'date_debut'  => 'required|date',
            'date_fin'    => 'nullable|date|after_or_equal:date_debut',
            'heure'       => 'nullable|string|max:10',
            'lieu'        => 'nullable|string|max:200',
            'type'        => 'nullable|string|max:60',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);
    }
}
