<?php

namespace App\Http\Controllers;

use App\Models\{Membre, Departement, HoraireCulte};

class EgliseController extends Controller
{
    private function baseStats(): array
    {
        return [
            // 'membres'     => Membre::where('statut', 'actif')->count(),
            'departements'=> Departement::count(),
            'missions' => \App\Models\Mission::where('actif', true)->count(),
            'annees'      => (int) date('Y') - 1990,
        ];
    }

    public function index()
    {
        return view('eglise.index', [
            'stats' => $this->baseStats(),
        ]);
    }

    public function histoire()
    {
        return view('eglise.histoire');
    }

    public function vision()
    {
        return view('eglise.vision');
    }

    public function pasteurs()
    {
        $pasteurs = Membre::where('est_dirigeant', true)
            ->orderBy('ordre', 'asc')
            ->get();

        $pasteurPrincipal = $pasteurs->first();
        $autresPasteurs   = $pasteurs->skip(1);

        return view('eglise.pasteurs', compact('pasteurPrincipal', 'autresPasteurs'));
    }

    public function departements()
    {
        $departements = Departement::withCount('membres')
            ->orderBy('ordre')
            ->get();

        return view('eglise.departements', compact('departements'));
    }
}
