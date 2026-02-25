<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\{Culte, Actualite, Mission, Membre, Contact};

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'membres'    => Membre::where('actif', true)->count(),
                'cultes'     => Culte::publie()->count(),
                'actualites' => Actualite::publie()->count(),
                'missions'   => Mission::actif()->count(),
            ],
            'dernieresActualites' => Actualite::with('categorie')->orderByDesc('created_at')->take(8)->get(),
            'recentsCultes'       => Culte::orderByDesc('date_culte')->take(6)->get(),
            'culteLive'           => Culte::live()->first(),
            'recentContacts'      => Contact::orderByDesc('created_at')->take(5)->get(),
        ]);
    }
}
