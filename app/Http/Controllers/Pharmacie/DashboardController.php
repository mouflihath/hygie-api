<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le dashboard pour le partenaire pharmacie.
     */
    public function index()
    {
        // 1. On récupère l'utilisateur connecté (le compte User)
        $user = Auth::user();

        // 2. On récupère les détails de la pharmacie associée
        // Note: Cela nécessite que la relation soit définie dans ton modèle User
        $pharmacie = $user->pharmacie;

        // 3. Sécurité : si pour une raison X l'utilisateur n'a pas de profil pharmacie
        if (!$pharmacie) {
            return redirect()->route('home')->with('error', 'Profil pharmacie introuvable.');
        }

        // 4. Tu peux ajouter ici des statistiques (ex: nombre de commandes)
        // $commandesRecentes = $pharmacie->commandes()->latest()->take(5)->get();

        return view('pharmacie.dashboard', compact('user', 'pharmacie'));
    }
}
