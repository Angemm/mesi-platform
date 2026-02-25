<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminParametresController extends Controller
{
    public function index()
    {
        $stats = [
            'membres'  => \App\Models\Membre::where('statut', 'actif')->count(),
            'cultes'   => \App\Models\Culte::where('publie', true)->count(),
            'missions' => \App\Models\Mission::where('statut', 'active')->count(),
            'annees'   => (int) date('Y') - 1990,
        ];

        return view('admin.parametres.index', compact('stats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom_eglise'      => 'required|string|max:200',
            'sigle'           => 'nullable|string|max:20',
            'adresse'         => 'nullable|string|max:300',
            'telephone'       => 'nullable|string|max:30',
            'email'           => 'nullable|email|max:150',
            'description'     => 'nullable|string|max:500',
            'facebook'        => 'nullable|string|max:300',
            'youtube'         => 'nullable|string|max:300',
            'instagram'       => 'nullable|string|max:300',
            'whatsapp'        => 'nullable|string|max:50',
            'seo_titre'       => 'nullable|string|max:200',
            'seo_description' => 'nullable|string|max:300',
            'logo'            => 'nullable|image|max:2048',
            'stats'           => 'nullable|array',
            'stats.*'         => 'nullable|integer|min:0',
        ]);

        // Mise à jour du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->storeAs('images', 'logo.jpg', 'public');
        }

        // Ecriture dans le fichier de config (mesi.php)
        $configPath = config_path('mesi.php');

        $configData = [
            'nom_eglise'      => $request->nom_eglise,
            'sigle'           => $request->sigle ?? 'M.E.SI',
            'adresse'         => $request->adresse,
            'telephone'       => $request->telephone,
            'email'           => $request->email,
            'description'     => $request->description,
            'facebook'        => $request->facebook,
            'youtube'         => $request->youtube,
            'instagram'       => $request->instagram,
            'whatsapp'        => $request->whatsapp,
            'seo_titre'       => $request->seo_titre,
            'seo_description' => $request->seo_description,
        ];

        // Mettre à jour les stats dans la DB si un modèle Stat existe
        // Sinon on peut les stocker en config ou dans une table parametres
        if ($request->filled('stats')) {
            foreach ($request->stats as $key => $value) {
                \App\Models\Parametre::updateOrCreate(
                    ['cle' => 'stat_'.$key],
                    ['valeur' => (string) $value]
                );
            }
        }

        // Écrire la config dans le fichier
        $export = "<?php\n\nreturn ".var_export($configData, true).";\n";
        file_put_contents($configPath, $export);

        // Vider le cache de config
        try {
            \Artisan::call('config:clear');
        } catch (\Exception $e) {
            // Silencieux en production si Artisan n'est pas accessible
        }

        return back()->with('success', 'Paramètres enregistrés avec succès.');
    }
}
