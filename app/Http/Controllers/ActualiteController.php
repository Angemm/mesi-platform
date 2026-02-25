<?php
namespace App\Http\Controllers;

use App\Models\{Actualite, CategorieActualite};
use Illuminate\Http\Request;

class ActualiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Actualite::where('publie', true)->with('categorie');

        if ($request->categorie) {
            $query->whereHas('categorie', fn($q) => $q->where('slug', $request->categorie));
        }

        return view('actualites.index', [
            'actualites'  => $query->orderByDesc('created_at')->paginate(9),
            'categories'  => CategorieActualite::withCount(['actualites' => fn($q) => $q->where('publie', true)])->get(),
            'enVedette'   => Actualite::where('publie', true)->where('en_vedette', true)->latest()->first(),
        ]);
    }

    public function show(Actualite $actualite)
    {
        abort_unless($actualite->publie, 404);
        $actualite->increment('vues');

        return view('actualites.show', [
            'actualite' => $actualite->load(['categorie', 'auteur']),
            'similaires' => Actualite::where('publie', true)
                ->where('id', '!=', $actualite->id)
                ->where('categorie_id', $actualite->categorie_id)
                ->latest()->take(4)->get(),
        ]);
    }
}
