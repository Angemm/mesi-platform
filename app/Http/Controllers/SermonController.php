<?php

namespace App\Http\Controllers;

use App\Models\Sermon;
use Illuminate\Http\Request;

class SermonController extends Controller
{
    public function index(Request $request)
    {
        $query = Sermon::where('publie', true);

        // Recherche
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('titre', 'like', "%{$q}%")
                   ->orWhere('predicateur', 'like', "%{$q}%")
                   ->orWhere('passage_biblique', 'like', "%{$q}%");
            });
        }

        // Filtre série (champ texte dans ton modèle)
        if ($request->filled('serie')) {
            $query->where('serie', $request->serie);
        }

        // Filtre prédicateur
        if ($request->filled('predicateur')) {
            $query->where('predicateur', $request->predicateur);
        }

        $sermons = $query->orderByDesc('date_predication')
                         ->paginate(12)
                         ->withQueryString();

        // Sermon vedette (si tu veux garder ce concept)
        $sermonVedette = Sermon::where('publie', true)
            ->orderByDesc('date_predication')
            ->first();

        // Liste séries uniques
        $series = Sermon::whereNotNull('serie')
            ->distinct()
            ->pluck('serie');

        // Liste prédicateurs
        $predicateurs = Sermon::where('publie', true)
            ->whereNotNull('predicateur')
            ->distinct()
            ->pluck('predicateur');

        return view('sermons.index', compact(
            'sermons',
            'sermonVedette',
            'series',
            'predicateurs'
        ));
    }

    public function show(Sermon $sermon)
    {
        abort_if(!$sermon->publie, 404);

        // Sermons de la même série
        $sermonsSerie = collect();
        if ($sermon->serie) {
            $sermonsSerie = Sermon::where('serie', $sermon->serie)
                ->where('id', '!=', $sermon->id)
                ->where('publie', true)
                ->orderBy('date_predication')
                ->get();
        }

        // Sermons récents
        $sermonsRecents = Sermon::where('publie', true)
            ->where('id', '!=', $sermon->id)
            ->orderByDesc('date_predication')
            ->take(5)
            ->get();

        return view('sermons.show', compact(
            'sermon',
            'sermonsSerie',
            'sermonsRecents'
        ));
    }
}
