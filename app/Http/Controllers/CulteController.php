<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Culte, Actualite, Mission, Evenement, VersetJour};

class CulteController extends Controller

{
    public function index()
    {
        $culteLive = Culte::live()->first();
        $cultes = Culte::publie()
            ->when(request('type'), fn($q) => $q->where('type', request('type')))
            ->orderByDesc('date_culte')
            ->paginate(9);
        return view('cultes.index', compact('cultes', 'culteLive'));
    }

    public function show(Culte $culte)
    {
        abort_unless($culte->publie, 404);
        $culte->increment('vues');
        $suggestions = Culte::publie()->where('id', '!=', $culte->id)->take(4)->inRandomOrder()->get();
        return view('cultes.show', compact('culte', 'suggestions'));
    }

    public function live()
    {
        $culteLive = Culte::live()->firstOrFail();
        return view('cultes.live', compact('culteLive'));
    }
}
