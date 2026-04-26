<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Expedition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpeditionController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'nom_client' => 'required|string|max:255',
            'adresse_livraison' => 'required|string',
            'livreur_id' => 'required|exists:livreurs,id',
        ]);

        // 2. Création en base de données
        Expedition::create([
            'pharmacie_id' => Auth::user()->pharmacie->id,
            'livreur_id' => $request->livreur_id,
            'nom_client' => $request->nom_client,
            'adresse_livraison' => $request->adresse_livraison,
            'status' => 'en_attente', // Statut par défaut
        ]);

        // 3. Redirection avec message de succès
        return back()->with('success', 'L\'expédition a été lancée avec succès !');
    }
}
