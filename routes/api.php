<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\PharmacyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- 1. ROUTES PUBLIQUES (Accessibles sans jeton/token) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ON DÉPLACE CETTE LIGNE ICI POUR QU'ELLE SOIT PUBLIQUE
Route::get('/pharmacies', [PharmacyController::class, 'getPharmaciesForApi']);


// --- 2. ROUTES PROTÉGÉES (Connexion obligatoire via Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        // Charge aussi les infos de la table patients
        return $request->user()->load('patient');
    });

    // Tu peux ajouter ici d'autres routes qui nécessitent d'être connecté
    // Ex: Route::post('/commander', [OrderController::class, 'store']);

});
