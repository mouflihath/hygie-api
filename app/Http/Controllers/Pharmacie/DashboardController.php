<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pharmacie   = Auth::user()->pharmacie;
        $pharmacieId = $pharmacie?->id ?? 0;

        $commandes = Commande::where('pharmacie_id', $pharmacieId)
            ->with(['lignes', 'patient'])
            ->orderBy('created_at', 'desc')
            ->get();

        $commandesEnAttente = $commandes->where('statut', 'en_attente')->count();
        $totalLivrees       = $commandes->where('statut', 'validée')->count();
        $totalCommandes     = $commandes->count();

        $totalProduits = DB::table('stocks')
            ->where('pharmacie_id', $pharmacieId)
            ->sum('quantite');

        return view('pharmacie.dashboard', compact(
            'commandes',
            'commandesEnAttente',
            'totalLivrees',
            'totalCommandes',
            'totalProduits',
            'pharmacie'
        ));
    }

    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        // Sécurité : Vérifie que la commande appartient bien à la pharmacie connectée
        if ($commande->pharmacie_id !== Auth::user()->pharmacie?->id) {
            abort(403);
        }

        // Validation simple pour s'assurer que la valeur envoyée est correcte
        $request->validate([
            'statut' => 'required|string|in:en_attente,validée'
        ]);

        // ATTENTION : Si ta colonne en Base de Données s'appelle 'statut', remplace 'etat_commande' à gauche par 'statut'
        $commande->statut = $request->input('statut');

        // On retire les slashs pour que ça sauvegarde enfin en BDD !
        $commande->save();

        return back()->with('success', 'Le statut de la commande a bien été mis à jour.');
    }
}
