<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminMissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Mission::query();

        if ($request->filled('q')) {
            $query->where('nom', 'like', '%'.$request->q.'%')
                  ->orWhere('pays', 'like', '%'.$request->q.'%');
        }

        // tri par actif puis nom
        $missions = $query->orderByDesc('actif')
                          ->orderBy('nom')
                          ->paginate(12)
                          ->withQueryString();

        return view('admin.missions.index', compact('missions'));
    }

    public function create()
    {
        return view('admin.missions.form');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['slug'] = Str::slug($validated['nom']).'-'.now()->format('YmdHis');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('missions', 'public');
        }

        Mission::create($validated);

        return redirect()->route('admin.missions.index')
            ->with('success', 'Mission créée avec succès.');
    }

    public function edit(Mission $mission)
    {
        return view('admin.missions.form', compact('mission'));
    }

    public function update(Request $request, Mission $mission)
    {
        $validated = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($mission->image ?? '');
            $validated['image'] = $request->file('image')->store('missions', 'public');
        }

        $mission->update($validated);

        return redirect()->route('admin.missions.index')
            ->with('success', 'Mission mise à jour.');
    }

    public function destroy(Mission $mission)
    {
        Storage::disk('public')->delete($mission->image ?? '');
        $mission->delete();

        return back()->with('success', 'Mission supprimée.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'nom'          => 'required|string|max:200',
            'pays'         => 'nullable|string|max:100',
            'region'       => 'nullable|string|max:100',
            'description'  => 'nullable|string',
            'responsable'  => 'nullable|string|max:200',
            'objectif_don' => 'nullable|numeric|min:0',
            'actif'        => 'required|boolean',
            'image'        => 'nullable|image|max:2048',
        ]);
    }
}
