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
        $pasteurs = Membre::whereIn('role', ['pasteur', 'ancien', 'diacre'])
            ->where('actif', true)
            ->orderBy('nom', 'asc')
            ->get();

        $pasteurPrincipal = $pasteurs->where('role', 'pasteur')->first();
        $autresPasteurs   = $pasteurs->filter(fn($m) => $m->id !== optional($pasteurPrincipal)->id);

        return view('eglise.pasteurs', compact('pasteurPrincipal', 'autresPasteurs'));
    }

    public function departements()
    {
        $departements = Departement::withCount('membres')
            ->orderBy('nom')
            ->get();

        return view('eglise.departements', compact('departements'));
    }
}
