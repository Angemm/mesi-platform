<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoraireCulte;
use Illuminate\Http\Request;

class AdminHoraireController extends Controller
{
    public function index()
    {
        $horaires = HoraireCulte::orderBy('ordre')->get();
        return view('admin.horaires.index', compact('horaires'));
    }

    /**
     * Mise à jour groupée de tous les horaires depuis le formulaire
     */
    public function update(Request $request)
    {
        $request->validate([
            'horaires'                => 'required|array',
            'horaires.*.jour'         => 'required|string|max:20',
            'horaires.*.heure'        => 'required|string|max:10',
            'horaires.*.type_culte'   => 'nullable|string|max:100',
        ]);

        // Supprimer les horaires existants non envoyés
        $idsExistants = collect($request->horaires)
            ->pluck('id')
            ->filter()
            ->values()
            ->toArray();

        HoraireCulte::whereNotIn('id', $idsExistants)->delete();

        foreach ($request->horaires as $i => $data) {
            HoraireCulte::updateOrCreate(
                ['id' => $data['id'] ?? null],
                [
                    'jour'       => $data['jour'],
                    'heure'      => $data['heure'],
                    'type_culte' => $data['type_culte'] ?? null,
                    'actif'      => isset($data['actif']),
                    'ordre'      => $i,
                ]
            );
        }

        return back()->with('success', 'Horaires mis à jour avec succès.');
    }

    // Les méthodes inutilisées de la resource sont vides
    public function create()  { return redirect()->route('admin.horaires.index'); }
    public function store(Request $request) { return $this->update($request); }
    public function show(HoraireCulte $horaire) { return redirect()->route('admin.horaires.index'); }
    public function edit(HoraireCulte $horaire) { return redirect()->route('admin.horaires.index'); }
    public function destroy(HoraireCulte $horaire)
    {
        $horaire->delete();
        return back()->with('success', 'Horaire supprimé.');
    }
}
