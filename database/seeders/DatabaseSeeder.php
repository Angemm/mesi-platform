<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{HoraireCulte, VersetJour, CategorieActualite, Departement};
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Administrateur par défaut
        \App\Models\User::create([
            'name'     => 'Administrateur M.E.SI',
            'email'    => 'admin@mesi.org',
            'password' => Hash::make('Admin@MESI2024!'), // CHANGER EN PRODUCTION
            'role'     => 'admin',
        ]);

        // Horaires des cultes
        $horaires = [
            ['jour' => 'Dimanche', 'heure' => '09:00 — 12:00', 'type_culte' => 'Culte Principal', 'ordre' => 1],
            ['jour' => 'Mercredi', 'heure' => '18:30 — 20:00', 'type_culte' => 'Étude Biblique',  'ordre' => 2],
            ['jour' => 'Vendredi', 'heure' => '19:00 — 21:00', 'type_culte' => 'Prière',          'ordre' => 3],
            ['jour' => 'Samedi',   'heure' => '15:00 — 17:00', 'type_culte' => 'Jeunesse',        'ordre' => 4],
        ];
        foreach ($horaires as $h) HoraireCulte::create($h + ['actif' => true]);

        // Verset du jour
        VersetJour::create([
            'texte'      => "Car je connais les projets que j'ai formés sur vous, dit l'Éternel, projets de paix et non de malheur, afin de vous donner un avenir et de l'espérance.",
            'reference'  => 'Jérémie 29:11',
            'traduction' => 'LSG',
            'actif'      => true,
            'date'       => today(),
        ]);

        // Catégories d'actualités
        $categories = [
            ['nom' => 'Annonces',      'slug' => 'annonces',      'couleur' => '#e8b04b'],
            ['nom' => 'Témoignages',   'slug' => 'temoignages',   'couleur' => '#1a7a3c'],
            ['nom' => 'Enseignements', 'slug' => 'enseignements', 'couleur' => '#2b6cb0'],
            ['nom' => 'Missions',      'slug' => 'missions',       'couleur' => '#c53030'],
            ['nom' => 'Événements',    'slug' => 'evenements',    'couleur' => '#553c9a'],
        ];
        foreach ($categories as $c) CategorieActualite::create($c);

        // Départements
        $departements = [
            ['nom' => 'Jeunesse & Adolescents', 'icone' => 'fas fa-star', 'couleur' => '#e8b04b'],
            ['nom' => 'Louange & Adoration',    'icone' => 'fas fa-music','couleur' => '#1a7a3c'],
            ['nom' => 'Évangélisation',          'icone' => 'fas fa-globe','couleur' => '#2b6cb0'],
            ['nom' => 'Prière',                  'icone' => 'fas fa-pray', 'couleur' => '#553c9a'],
            ['nom' => 'Diaconie & Action Sociale','icone' => 'fas fa-heart','couleur' => '#c53030'],
            ['nom' => 'Femmes de l\'Église',     'icone' => 'fas fa-female','couleur' => '#e8b04b'],
        ];
        foreach ($departements as $d) Departement::create($d);
    }
}
