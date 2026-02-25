<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    CulteController,
    ActualiteController,
    MissionController,
    ContactController,
    NewsletterController,
    DonController,
    EgliseController,
    MembrePublicController,
    SermonController,
};
use App\Http\Controllers\Admin\{
    DashboardController,
    AdminCulteController,
    AdminActualiteController,
    AdminMissionController,
    AdminMembreController,
    AdminDepartementController,
    AdminEvenementController,
    AdminDonController,
    AdminContactController,
    AdminNewsletterController,
    AdminHoraireController,
    AdminVersetController,
    AdminSermonController,
    AdminParametresController,
};

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Église
Route::prefix('eglise')->name('eglise.')->group(function () {
    Route::get('/',           [EgliseController::class, 'index'])->name('index');
    Route::get('/histoire',   [EgliseController::class, 'histoire'])->name('histoire');
    Route::get('/vision',     [EgliseController::class, 'vision'])->name('vision');
    Route::get('/pasteurs',   [EgliseController::class, 'pasteurs'])->name('pasteurs');
    Route::get('/departements',[EgliseController::class, 'departements'])->name('departements');
});

// Cultes & Retransmissions
Route::prefix('cultes')->name('cultes.')->group(function () {
    Route::get('/',       [CulteController::class, 'index'])->name('index');
    Route::get('/live',   [CulteController::class, 'live'])->name('live');
    Route::get('/{culte:slug}', [CulteController::class, 'show'])->name('show');
});

// Actualités
Route::prefix('actualites')->name('actualites.')->group(function () {
    Route::get('/',                       [ActualiteController::class, 'index'])->name('index');
    Route::get('/{actualite:slug}',       [ActualiteController::class, 'show'])->name('show');
});

// Missions
Route::prefix('missions')->name('missions.')->group(function () {
    Route::get('/',                   [MissionController::class, 'index'])->name('index');
    Route::get('/{mission:slug}',     [MissionController::class, 'show'])->name('show');
});

// Membres (Annuaire public)
Route::prefix('membres')->name('membres.')->group(function () {
    Route::get('/',                 [MembrePublicController::class, 'index'])->name('index');
});

// Sermons
Route::prefix('sermons')->name('sermons.')->group(function () {
    Route::get('/',                   [SermonController::class, 'index'])->name('index');
    Route::get('/{sermon:slug}',      [SermonController::class, 'show'])->name('show');
});

// Contact
Route::get('/contact',   [ContactController::class, 'index'])->name('contact');
Route::post('/contact',  [ContactController::class, 'store'])->name('contact.store');

// Don
Route::get('/don',       [DonController::class, 'index'])->name('don');
Route::post('/don',      [DonController::class, 'store'])->name('don.store');

// Newsletter
Route::post('/newsletter',          [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION (Laravel Breeze/Fortify inclus)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ROUTES ADMIN (protégées, rôle admin/editeur)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,editeur'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',              [DashboardController::class,    'index'])->name('dashboard');

    // Cultes
    Route::resource('cultes',    AdminCulteController::class);

    // Actualités
    Route::resource('actualites', AdminActualiteController::class);

    // Missions
    Route::resource('missions',  AdminMissionController::class);

    // Membres
    Route::resource('membres',   AdminMembreController::class);

    // Départements
    Route::resource('departements', AdminDepartementController::class);

    // Événements
    Route::resource('evenements',   AdminEvenementController::class);

    // Sermons
    Route::resource('sermons',      AdminSermonController::class);

    // Dons
    Route::get('dons',              [AdminDonController::class,       'index'])->name('dons.index');
    Route::patch('dons/{don}',      [AdminDonController::class,       'updateStatut'])->name('dons.updateStatut');

    // Contacts / Messages
    Route::get('contacts',          [AdminContactController::class,   'index'])->name('contacts.index');
    Route::get('contacts/{contact}',[AdminContactController::class,   'show'])->name('contacts.show');
    Route::delete('contacts/{contact}',[AdminContactController::class,'destroy'])->name('contacts.destroy');

    // Newsletter
    Route::get('newsletter',        [AdminNewsletterController::class,'index'])->name('newsletter.index');
    Route::post('newsletter/envoyer',[AdminNewsletterController::class,'envoyer'])->name('newsletter.envoyer');
    Route::delete('newsletter/{newsletter}',[AdminNewsletterController::class,'destroy'])->name('newsletter.destroy');

    // Horaires cultes
    Route::resource('horaires',     AdminHoraireController::class)->names('horaires');

    // Verset du jour
    Route::get('verset',            [AdminVersetController::class,    'edit'])->name('verset.edit');
    Route::put('verset',            [AdminVersetController::class,    'update'])->name('verset.update');

    // Paramètres généraux
    Route::get('parametres',        [AdminParametresController::class,'index'])->name('parametres');
    Route::put('parametres',        [AdminParametresController::class,'update'])->name('parametres.update');
});
