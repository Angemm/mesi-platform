<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminNewsletterController extends Controller
{
    public function index(Request $request)
    {
        $abonnes = Newsletter::orderByDesc('created_at')->paginate(25)->withQueryString();

        $stats = [
            'total'  => Newsletter::count(),
            'actifs' => Newsletter::where('actif', true)->count(),
            'envois' => 0, // à alimenter si vous loggez les envois
        ];

        return view('admin.newsletter.index', compact('abonnes', 'stats'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'sujet'   => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        $abonnes = Newsletter::where('actif', true)->get();

        foreach ($abonnes as $abonne) {
            // Ici vous pouvez utiliser un Mailable ou Mail::raw()
            // Exemple minimal :
            // Mail::raw($request->message, function ($m) use ($abonne, $request) {
            //     $m->to($abonne->email)->subject($request->sujet);
            // });
        }

        return back()->with('success', "Newsletter envoyée à {$abonnes->count()} abonné(s).");
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return back()->with('success', 'Abonné supprimé.');
    }

    public function export(): StreamedResponse
    {
        $abonnes = Newsletter::where('actif', true)->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="newsletter-abonnes-'.now()->format('Y-m-d').'.csv"',
        ];

        return response()->stream(function () use ($abonnes) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF"); // BOM UTF-8 pour Excel
            fputcsv($handle, ['Email', 'Nom', 'Date d\'inscription'], ';');

            foreach ($abonnes as $a) {
                fputcsv($handle, [$a->email, $a->nom ?? '', $a->created_at->format('d/m/Y')], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }
}
