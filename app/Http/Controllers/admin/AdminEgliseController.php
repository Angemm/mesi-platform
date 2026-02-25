<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Membre, Departement};
use Illuminate\Http\Request;

/**
 * AdminEgliseController
 * Gère les pages de présentation de l'église depuis l'admin
 * (contenu éditorial : histoire, vision, textes de présentation)
 */
class AdminEgliseController extends Controller
{
    public function index()
    {
        $dirigeants   = Membre::where('est_dirigeant', true)->orderBy('ordre')->get();
        $departements = Departement::withCount('membres')->orderBy('ordre')->get();

        return view('admin.eglise.index', compact('dirigeants', 'departements'));
    }

    public function updatePresentation(Request $request)
    {
        $request->validate([
            'titre_presentation' => 'nullable|string|max:200',
            'texte_presentation' => 'nullable|string',
            'texte_histoire'     => 'nullable|string',
            'texte_vision'       => 'nullable|string',
            'texte_mission'      => 'nullable|string',
        ]);

        foreach ($request->only([
            'titre_presentation',
            'texte_presentation',
            'texte_histoire',
            'texte_vision',
            'texte_mission',
        ]) as $cle => $valeur) {
            \App\Models\Parametre::updateOrCreate(
                ['cle' => $cle],
                ['valeur' => $valeur ?? '']
            );
        }

        return back()->with('success', 'Textes de présentation mis à jour.');
    }
}
