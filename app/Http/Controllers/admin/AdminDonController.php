<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Don;
use Illuminate\Http\Request;

class AdminDonController extends Controller
{
    public function index(Request $request)
    {
        $query = Don::with('mission');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('nom_donateur',   'like', "%{$q}%")
                   ->orWhere('email_donateur','like', "%{$q}%");
            });
        }

        if ($request->filled('mission')) {
            $query->where('mission_id', $request->mission);
        }

        if ($request->filled('mois')) {
            $query->whereYear('created_at',  substr($request->mois, 0, 4))
                  ->whereMonth('created_at', substr($request->mois, 5, 2));
        }

        $dons = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $stats = [
            'total_dons'        => Don::where('statut', 'confirme')->sum('montant'),
            'dons_mois'         => Don::whereMonth('created_at', now()->month)->count(),
            'donateurs'         => Don::distinct('email_donateur')->count(),
            'missions_financees'=> Don::distinct('mission_id')->whereNotNull('mission_id')->count(),
        ];

        return view('admin.dons.index', compact('dons', 'stats'));
    }

    public function updateStatut(Request $request, Don $don)
    {
        $request->validate([
            'statut' => 'required|in:confirme,en_attente,annule',
        ]);

        $don->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut du don mis à jour.');
    }
}
