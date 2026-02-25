<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        \App\Models\Newsletter::firstOrCreate(
            ['email' => $request->email],
            ['actif' => true, 'token' => \Str::random(32)]
        );
        return back()->with('success', 'Merci ! Vous êtes maintenant abonné à notre newsletter.');
    }

    public function unsubscribe($token)
    {
        $sub = \App\Models\Newsletter::where('token', $token)->firstOrFail();
        $sub->update(['actif' => false]);
        return redirect()->route('home')->with('success', 'Vous avez été désabonné avec succès.');
    }
}
