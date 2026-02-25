<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Sermon, SerieSermon};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminSermonController extends Controller
{
    public function index(Request $request)
    {
        $query = Sermon::with('serie');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('titre',        'like', "%{$q}%")
                   ->orWhere('predicateur','like', "%{$q}%");
            });
        }

        $sermons = $query->orderByDesc('date_sermon')->paginate(15)->withQueryString();

        return view('admin.sermons.index', compact('sermons'));
    }

    public function create()
    {
        $series = SerieSermon::orderBy('nom')->get();
        return view('admin.sermons.form', compact('series'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['slug']        = Str::slug($validated['titre']).'-'.now()->format('YmdHis');
        $validated['publie']      = $request->boolean('publie');
        $validated['est_vedette'] = $request->boolean('est_vedette');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sermons', 'public');
        }

        if ($request->hasFile('fichier_audio')) {
            $validated['fichier_audio'] = $request->file('fichier_audio')->store('sermons/audio', 'public');
        }

        Sermon::create($validated);

        return redirect()->route('admin.sermons.index')
            ->with('success', 'Sermon créé avec succès.');
    }

    public function edit(Sermon $sermon)
    {
        $series = SerieSermon::orderBy('nom')->get();
        return view('admin.sermons.form', compact('sermon', 'series'));
    }

    public function update(Request $request, Sermon $sermon)
    {
        $validated = $this->validateRequest($request);
        $validated['publie']      = $request->boolean('publie');
        $validated['est_vedette'] = $request->boolean('est_vedette');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($sermon->image ?? '');
            $validated['image'] = $request->file('image')->store('sermons', 'public');
        }

        if ($request->hasFile('fichier_audio')) {
            Storage::disk('public')->delete($sermon->fichier_audio ?? '');
            $validated['fichier_audio'] = $request->file('fichier_audio')->store('sermons/audio', 'public');
        }

        $sermon->update($validated);

        return redirect()->route('admin.sermons.index')
            ->with('success', 'Sermon mis à jour.');
    }

    public function destroy(Sermon $sermon)
    {
        Storage::disk('public')->delete($sermon->image ?? '');
        Storage::disk('public')->delete($sermon->fichier_audio ?? '');
        $sermon->delete();

        return back()->with('success', 'Sermon supprimé.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'titre'              => 'required|string|max:200',
            'predicateur'        => 'nullable|string|max:100',
            'date_sermon'        => 'nullable|date',
            'reference_biblique' => 'nullable|string|max:100',
            'verset_cle'         => 'nullable|string|max:500',
            'duree'              => 'nullable|string|max:20',
            'description'        => 'nullable|string',
            'lien_video'         => 'nullable|url|max:500',
            'type'               => 'nullable|in:video,audio,texte',
            'serie_id'           => 'nullable|exists:serie_sermons,id',
            'image'              => 'nullable|image|max:2048',
            'fichier_audio'      => 'nullable|mimes:mp3,ogg,wav,m4a|max:51200',
        ]);
    }
}
