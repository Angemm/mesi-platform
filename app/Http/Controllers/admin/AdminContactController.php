<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('statut')) {
            $query->where('lu', $request->statut === 'lu');
        }

        $unread   = Contact::where('lu', false)->count();
        $contacts = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.contacts.index', compact('contacts', 'unread'));
    }

    public function show(Contact $contact)
    {
        // Marquer comme lu
        if (!$contact->lu) {
            $contact->update(['lu' => true]);
        }

        // Navigation entre messages
        $precedent = Contact::where('id', '<', $contact->id)->orderByDesc('id')->first();
        $suivant   = Contact::where('id', '>', $contact->id)->orderBy('id')->first();

        return view('admin.contacts.show', compact('contact', 'precedent', 'suivant'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé.');
    }
}
