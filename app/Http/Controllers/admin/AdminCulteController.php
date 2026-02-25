<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Culte;
use Illuminate\Http\Request;



class AdminCulteController extends Controller
{
    public function index()
    {
        $cultes = Culte::orderByDesc('date_culte')->paginate(15);
        return view('admin.cultes.index', compact('cultes'));
    }

    public function create() { return view('admin.cultes.form'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'           => 'required|string|max:200',
            'description'     => 'nullable|string',
            'date_culte'      => 'required|date',
            'heure'           => 'nullable|string|max:10',
            'predicateur'     => 'nullable|string|max:100',
            'passage_biblique'=> 'nullable|string|max:100',
            'type'            => 'required|string',
            'image'           => 'nullable|image|max:2048',
            'lien_video'      => 'nullable|url',
            'lien_live'       => 'nullable|url',
            'est_live'        => 'boolean',
            'est_a_venir'     => 'boolean',
            'publie'          => 'boolean',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cultes', 'public');
        }
        $data['slug'] = \Str::slug($data['titre']) . '-' . now()->timestamp;
        Culte::create($data);
        return redirect()->route('admin.cultes.index')->with('success', 'Culte créé avec succès !');
    }

    public function edit(Culte $culte) { return view('admin.cultes.form', compact('culte')); }

    public function update(Request $request, Culte $culte)
    {
        $data = $request->validate([
            'titre'           => 'required|string|max:200',
            'description'     => 'nullable|string',
            'date_culte'      => 'required|date',
            'heure'           => 'nullable|string|max:10',
            'predicateur'     => 'nullable|string|max:100',
            'passage_biblique'=> 'nullable|string|max:100',
            'type'            => 'required|string',
            'image'           => 'nullable|image|max:2048',
            'lien_video'      => 'nullable|url',
            'lien_live'       => 'nullable|url',
            'est_live'        => 'boolean',
            'est_a_venir'     => 'boolean',
            'publie'          => 'boolean',
        ]);
        if ($request->hasFile('image')) {
            if ($culte->image) \Storage::disk('public')->delete($culte->image);
            $data['image'] = $request->file('image')->store('cultes', 'public');
        }
        $culte->update($data);
        return redirect()->route('admin.cultes.index')->with('success', 'Culte mis à jour !');
    }

    public function destroy(Culte $culte)
    {
        if ($culte->image) \Storage::disk('public')->delete($culte->image);
        $culte->delete();
        return back()->with('success', 'Culte supprimé.');
    }
}
