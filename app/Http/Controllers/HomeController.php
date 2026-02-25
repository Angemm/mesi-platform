<?php
namespace App\Http\Controllers;

use App\Models\{Culte, Actualite, Mission, Evenement, VersetJour, Membre};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.home', [
            'culteLive'           => Culte::where('est_live', true)->first(),
            'prochainsCultes'     => Culte::where('publie', true)->orderByDesc('date_culte')->take(6)->get(),
            'dernieresActualites' => Actualite::where('publie', true)->with('categorie')->orderByDesc('created_at')->take(3)->get(),
            'evenements'          => Evenement::where('date_debut', '>=', now())->where('publie', true)->orderBy('date_debut')->take(5)->get(),
            'missions'            => Mission::where('actif', true)->take(3)->get(),
            'dirigeants'          => Membre::whereIn('role', ['pasteur', 'ancien', 'diacre'])->where('actif', true)->take(6)->get(),
            'verset'              => VersetJour::where('actif', true)->where('date', today())->first()
                                     ?? VersetJour::where('actif', true)->inRandomOrder()->first(),
            'stats' => [
                'membres'  => Membre::where('actif', true)->count() ?: 120,
                'cultes'   => Culte::where('publie', true)->count() ?: 48,
                'missions' => Mission::where('actif', true)->count() ?: 5,
                'annees'   => now()->year - (int) config('mesi.fondation', 2005),
            ],
        ]);
    }
}
