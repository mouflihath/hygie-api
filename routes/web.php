<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Pharmacie\DashboardController as PharmacieDashboard;
use App\Http\Controllers\Pharmacie\StockController;
use App\Http\Controllers\Pharmacie\LivreurController;
use App\Http\Controllers\Pharmacie\ExpeditionController;
use App\Http\Controllers\Pharmacie\CommandesController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pharmacie\RevenusController;
use App\Http\Controllers\ProfilController;
// ─────────────────────────────────────────────────────────────────────────────
// ACCUEIL & AUTHENTIFICATION
// ─────────────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

// Redirection forcée du login pharmacie
Route::get('/login-pharmacie', function() {
    return redirect()->route('login');
})->name('pharmacie.login');

// ─────────────────────────────────────────────────────────────────────────────
// TOUR DE CONTRÔLE (Redirection après Login)
// ─────────────────────────────────────────────────────────────────────────────
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'pharmacie') {
        return redirect()->route('pharmacie.dashboard');
    }

    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// ─────────────────────────────────────────────────────────────────────────────
// SECTION ADMINISTRATION
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::prefix('pharmacies')->name('pharmacies.')->group(function () {
            Route::get('/',               [PharmacyController::class, 'index'])->name('index');
            Route::post('/store',         [PharmacyController::class, 'store'])->name('store');
            Route::put('/{pharmacie}',    [PharmacyController::class, 'update'])->name('update');
            Route::delete('/{pharmacie}', [PharmacyController::class, 'destroy'])->name('destroy');
            Route::get('/{pharmacie}', [PharmacyController::class, 'edit'])->name('edit');
        });
});

// Admin - nouvelles routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs.index');
    Route::get('/commandes',    [AdminController::class, 'commandes'])->name('commandes.index');
    Route::get('/revenus',      [AdminController::class, 'revenus'])->name('revenus.index');
    Route::get('/avis',         [AdminController::class, 'avis'])->name('avis.index');
    Route::delete('/utilisateurs/{user}', [AdminController::class, 'destroyUser'])->name('utilisateurs.destroy');
});
// ─────────────────────────────────────────────────────────────────────────────
// SECTION PHARMACIE
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:pharmacie'])
    ->prefix('pharmacie')
    ->name('pharmacie.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [PharmacieDashboard::class, 'index'])->name('dashboard');

        // Gestion du Stock
        Route::resource('stocks', StockController::class);

        // Gestion des Livreurs
        Route::prefix('livreurs')->name('livreurs.')->group(function () {
            Route::get('/',             [LivreurController::class, 'index'])->name('index');
            Route::post('/store',       [LivreurController::class, 'store'])->name('store');
            Route::put('/{livreur}',    [LivreurController::class, 'update'])->name('update');
            Route::delete('/{livreur}', [LivreurController::class, 'destroy'])->name('destroy');
        });

        // Expéditions
        Route::post('/expeditions/store', [ExpeditionController::class, 'store'])->name('expeditions.store');

        // COMMANDES
        Route::get('/commandes', [CommandesController::class, 'index'])->name('commandes');

        // Redirection sécurisée pour les visites GET accidentelles
        Route::get('/commandes/{id}/statut', function($id){
            return redirect()->route('pharmacie.dashboard');
        });

        // ✅ PATCH au lieu de PUT
        Route::patch('/commandes/{id}/statut', [PharmacieDashboard::class, 'updateStatut'])->name('commandes.statut');
});

Route::middleware(['auth'])->prefix('pharmacie')->name('pharmacie.')->group(function () {
    Route::get('/revenus', [RevenusController::class, 'index'])->name('revenus');
});

// ─────────────────────────────────────────────────────────────────────────────
// GESTION DU PROFIL
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth'])
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/',    [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/',  [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');