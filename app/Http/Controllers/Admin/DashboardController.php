<?php
// ════════════════════════════════════════════════════════════════════════════
// app/Http/Controllers/Admin/AdminDashboardController.php
// Alimente le dashboard admin avec stats réelles
// ════════════════════════════════════════════════════════════════════════════

namespace App\Http\Controllers\Admin;

use App\Models\Commande;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index()
{
    // On utilise le Query Builder pour les stats simples (plus rapide)
    $pharmacies = DB::table('pharmacies')->get();

    $totalCommandes = Commande::count();
    $commandesAujourdhui = Commande::whereDate('created_at', today())->count();

    // On s'assure que si sum() renvoie null, on affiche 0
    $revenuTotal = Commande::sum('commission_application') ?? 0;
    $revenuAujourdhui = Commande::whereDate('created_at', today())->sum('commission_application') ?? 0;

    $totalPatients = User::whereHas('patient')->count();

    $commandesRecentes = Commande::with('pharmacie')
        ->orderByDesc('created_at')
        ->limit(30)
        ->get();



    return view('admin.dashboard', compact(
        'pharmacies', 'totalCommandes', 'commandesAujourdhui',
        'revenuTotal', 'revenuAujourdhui', 'totalPatients',
        'commandesRecentes'
    ));
}
}
