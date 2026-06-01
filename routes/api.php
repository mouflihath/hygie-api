<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\OrdonnanceController;
use App\Http\Controllers\Api\MedicamentController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Api\PharmacyController as ApiPharmacyController;
use App\Http\Controllers\Api\WebhookController;

// ── ROUTES PUBLIQUES ──────────────────────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::get('/pharmacies',            [PharmacyController::class, 'getPharmaciesForApi']);
Route::get('/medicaments/recherche', [MedicamentController::class, 'rechercher']);
Route::post('/analyser-ordonnance',  [OrdonnanceController::class, 'analyser']);

// Commande — publique pour l'instant (tu pourras la protéger plus tard)
Route::post('/commander', [CommandeController::class, 'store']);

//  Routes pour le Dashboard de la Pharmacie / Livreur
Route::get('/pharmacie/{id}/commandes', [CommandeController::class, 'commandesPharmacie']);
Route::put('/commandes/{id}/statut',    [CommandeController::class, 'updateStatut']);

//  Routes pour le Patient (Suivi & Historique)
Route::get('/commandes/{id}/statut',    [CommandeController::class, 'getStatut']); // public ou privé selon ton choix

//  Route protégée par Sanctum pour l'historique du patient connecté
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patient/commandes', [CommandeController::class, 'monHistorique']);
});
// Webhook FedaPay — GET car FedaPay redirige le navigateur
Route::get('/webhooks/fedapay',  [WebhookController::class, 'handleFedaPay']);
Route::post('/webhooks/fedapay', [WebhookController::class, 'handleFedaPay']);

Route::post('/contact', [App\Http\Controllers\Api\ContactController::class, 'store']);

// ── ROUTES PROTÉGÉES (Sanctum) ────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user()->load('patient');
    });

    // Modification du profil patient

});
