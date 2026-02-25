<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VersetJour;
use Illuminate\Http\Request;

class AdminVersetController extends Controller
{
    public function edit()
    {
        $verset = VersetJour::latest()->first();
        return view('admin.verset.edit', compact('verset'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'texte'     => 'required|string|max:1000',
            'reference' => 'required|string|max:100',
        ]);

        VersetJour::updateOrCreate(
            ['id' => VersetJour::latest()->first()?->id],
            [
                'texte'     => $request->texte,
                'reference' => $request->reference,
                'actif'     => $request->boolean('actif', true),
            ]
        );

        return back()->with('success', 'Verset du jour mis à jour.');
    }
}
