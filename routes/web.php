<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Pharmacie\DashboardController as PharmacieDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

// --- ROUTES PROTÉGÉES (Utilisateurs connectés uniquement) ---
Route::middleware(['auth', 'verified', 'prevent.back.history'])->group(function () {

    /**
     * TOUR DE CONTRÔLE : Redirection intelligente selon le rôle
     */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'pharmacie' => redirect()->route('pharmacie.dashboard'),
            default     => redirect('/'),
        };
    })->name('dashboard');

    /**
     * SECTION ADMINISTRATION
     */
    Route::middleware(['can:admin-access'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard Principal : admin.dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // GESTION DES PHARMACIES : admin.pharmacies.*
        Route::prefix('pharmacies')->name('pharmacies.')->group(function() {
            Route::get('/', [PharmacyController::class, 'index'])->name('index');
            Route::post('/store', [PharmacyController::class, 'store'])->name('store');

            // CORRECTION : On enlève le "/update" de l'URL pour correspondre au formulaire
            Route::put('/{pharmacie}', [PharmacyController::class, 'update'])->name('update');

            Route::delete('/{pharmacie}', [PharmacyController::class, 'destroy'])->name('destroy');
        });
    });

    /**
     * SECTION PHARMACIE
     */
    Route::middleware(['can:pharmacie-access'])->prefix('pharmacie')->name('pharmacie.')->group(function () {
        Route::get('/dashboard', [PharmacieDashboard::class, 'index'])->name('dashboard');
    });

    /**
     * GESTION DU PROFIL
     */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});
