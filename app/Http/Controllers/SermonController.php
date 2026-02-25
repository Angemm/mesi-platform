<?php

namespace App\Http\Controllers;

use App\Models\Sermon;
use App\Models\SerieSermon;
use Illuminate\Http\Request;

class SermonController extends Controller
{
    public function index(Request $request)
    {
        $query = Sermon::with('serie')->where('publie', true);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('titre',       'like', "%{$q}%")
                   ->orWhere('predicateur','like', "%{$q}%")
                   ->orWhere('reference_biblique', 'like', "%{$q}%");
            });
        }

        if ($request->filled('serie')) {
            $query->where('serie_id', $request->serie);
        }

        if ($request->filled('predicateur')) {
            $query->where('predicateur', $request->predicateur);
        }

        $sermons = $query->orderByDesc('date_sermon')->paginate(12)->withQueryString();

        $sermonsVedette = Sermon::where('publie', true)
            ->where('est_vedette', true)
            ->latest('date_sermon')
            ->first();

        $series       = SerieSermon::orderBy('nom')->get();
        $predicateurs = Sermon::where('publie', true)
            ->whereNotNull('predicateur')
            ->distinct()
            ->pluck('predicateur');

        return view('sermons.index', compact(
            'sermons',
            'sermonsVedette',
            'series',
            'predicateurs'
        ));
    }

    public function show(Sermon $sermon)
    {
        abort_if(!$sermon->publie, 404);

        // Sermons de la même série (hors sermon courant)
        $sermonsSerie = collect();
        if ($sermon->serie_id) {
            $sermonsSerie = Sermon::where('serie_id', $sermon->serie_id)
                ->where('publie', true)
                ->orderBy('date_sermon')
                ->get();
        }

        // Sermons récents (hors série courante et sermon courant)
        $sermonsRecents = Sermon::where('publie', true)
            ->where('id', '!=', $sermon->id)
            ->orderByDesc('date_sermon')
            ->take(5)
            ->get();

        return view('sermons.show', compact('sermon', 'sermonsSerie', 'sermonsRecents'));
    }
}
