<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;
use App\Models\Notification;

class DashboardController extends Controller
{
  public function index()
    {
        $pharmacies = User::where('role', 'pharmacie')->latest()->get();

    // Statistiques avec les bons noms de colonnes
    $totalCommandes = Commande::count();
    $revenuTotal = Commande::where('statut', 'livree')->sum('montant_total');

    // Récupérer les notifications (messages)
    $commentaires = Notification::with('user')->latest()->take(4)->get();

    return view('admin.dashboard', compact('pharmacies', 'totalCommandes', 'revenuTotal', 'commentaires'));
    }

}
