<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Culte, Actualite, Mission, Evenement, VersetJour};

class MissionController extends Controller
{
    public function index()
    {
        $missions = Mission::actif()->paginate(9);
        return view('missions.index', compact('missions'));
    }

    public function show(Mission $mission)
    {
        abort_unless($mission->actif, 404);
        return view('missions.show', compact('mission'));
    }
}
