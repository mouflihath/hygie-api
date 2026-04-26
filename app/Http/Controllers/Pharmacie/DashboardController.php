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

        $commandesEnAttente = $commandes->where('etat_commande', 'en_attente')->count();
        $totalLivrees       = $commandes->where('etat_commande', 'livre')->count();
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

        if ($commande->pharmacie_id !== Auth::user()->pharmacie?->id) {
            abort(403);
        }

        $commande->statut = $request->statut;
       // $commande->save();

        return back()->with('success', 'Statut mis à jour.');
    }
}
