<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membre;
use App\Models\Departement;

class MembreController extends Controller
{
     public function index(Request $request)
    {
        $query = Membre::query()
            ->where('statut', 'actif')
            ->where('visible_public', true); // sécurité : seuls les membres qui acceptent d'être listés

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('prenom', 'like', "%{$q}%")
                   ->orWhere('nom',   'like', "%{$q}%");
            });
        }

        if ($request->filled('departement')) {
            $query->where('departement_id', $request->departement);
        }

        $membres = $query->orderBy('prenom')->paginate(24)->withQueryString();

        $departements = Departement::orderBy('nom')->get();

        $stats = [
            'membres'      => Membre::where('statut', 'actif')->count(),
            'departements' => Departement::count(),
            'missions'     => \App\Models\Mission::where('statut', 'active')->count(),
            'annees'       => (int) date('Y') - 1990,
        ];

        return view('membres.index', compact('membres', 'departements', 'stats'));
    }

}
