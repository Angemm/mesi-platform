<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() { return view('contact'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'       => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'telephone' => 'nullable|string|max:30',
            'sujet'     => 'required|string|max:200',
            'message'   => 'required|string|min:10',
        ]);
        Contact::create($data);
        // Optionnel: envoyer email à l'administration
        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les meilleurs délais.');
    }
}
