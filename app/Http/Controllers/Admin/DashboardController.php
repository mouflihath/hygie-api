<?php

namespace App\Http\Controllers\Admin;

use App\Models\Commande;
use App\Models\User;
use App\Models\Contact; // ✅ AJOUTÉ
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pharmacies = DB::table('pharmacies')->get();
        $totalCommandes = Commande::count();
        $commandesAujourdhui = Commande::whereDate('created_at', today())->count();

        $revenuTotal = Commande::sum('commission_application') ?? 0;
        $revenuAujourdhui = Commande::whereDate('created_at', today())->sum('commission_application') ?? 0;

        $totalPatients = User::whereHas('patient')->count();

        $commandesRecentes = Commande::with(['pharmacie'])
            ->orderByDesc('created_at')
            ->simplePaginate(5);

        // ✅ AJOUTÉ — récupère les derniers commentaires
        $commentaires = Contact::orderByDesc('created_at')->limit(8)->get();

        return view('admin.dashboard', compact(
            'pharmacies', 'totalCommandes', 'commandesAujourdhui',
            'revenuTotal', 'revenuAujourdhui', 'totalPatients',
            'commandesRecentes',
            'commentaires' // ✅ AJOUTÉ
        ));
    }
}