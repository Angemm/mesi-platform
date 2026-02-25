<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonController extends Controller
{
    public function index()
    {
        $missions = Mission::actif()->get();
        return view('don', compact('missions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donateur_nom'       => 'required|string|max:100',
            'donateur_email'     => 'nullable|email',
            'donateur_telephone' => 'nullable|string|max:30',
            'montant'            => 'required|numeric|min:100',
            'motif'              => 'nullable|string|max:200',
            'mission_id'         => 'nullable|exists:missions,id',
            'methode_paiement'   => 'required|string',
        ]);
        $don = \App\Models\Don::create($data + ['devise' => 'XOF', 'statut' => 'en_attente']);

        // Ici intégrer votre passerelle (CinetPay, Orange Money, MTN etc.)
        // Rediriger vers la passerelle de paiement...

        return back()->with('success', "Don de {$don->montant} XOF enregistré. Merci pour votre générosité !");
    }
}
