<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Configuration M.E.SI — Mission Évangélique Sion
    | Modifiez ces valeurs selon votre contexte
    |--------------------------------------------------------------------------
    */

    'nom'              => env('MESI_NOM', 'Mission Évangélique Sion'),
    'abreviation'      => env('MESI_ABBR', 'M.E.SI'),
    'devise'           => env('MESI_DEVISE', 'Partager la Parole, Bâtir le Royaume'),
    'fondation'        => env('MESI_FONDATION', 2005),

    // Coordonnées
    'adresse'          => env('MESI_ADRESSE', 'Votre adresse, Ville, Pays'),
    'telephone'        => env('MESI_TEL', '+000 00 00 00 00'),
    'email'            => env('MESI_EMAIL', 'contact@mesi.org'),
    'whatsapp_numero'  => env('MESI_WHATSAPP_NUM', '+000 00 00 00 00'),

    // Réseaux sociaux
    'facebook'         => env('MESI_FACEBOOK', '#'),
    'youtube'          => env('MESI_YOUTUBE', '#'),
    'instagram'        => env('MESI_INSTAGRAM', '#'),
    'whatsapp'         => env('MESI_WHATSAPP', '#'),

    // Devise financière
    'monnaie'          => env('MESI_MONNAIE', 'XOF'),
    'monnaie_symbole'  => env('MESI_MONNAIE_SYMBOLE', 'FCFA'),

    // Google Maps embed key (optionnel)
    'maps_api_key'     => env('MESI_MAPS_KEY', ''),
    'maps_embed_url'   => env('MESI_MAPS_EMBED', ''),
];
