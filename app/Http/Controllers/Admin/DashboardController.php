<?php
// app/Http/Controllers/Admin/AdminDashboardController.php

namespace App\Http\Controllers\Admin;

use App\Models\Commande;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats simples
        $pharmacies = DB::table('pharmacies')->get();
        $totalCommandes = Commande::count();
        $commandesAujourdhui = Commande::whereDate('created_at', today())->count();

        $revenuTotal = Commande::sum('commission_application') ?? 0;
        $revenuAujourdhui = Commande::whereDate('created_at', today())->sum('commission_application') ?? 0;

        $totalPatients = User::whereHas('patient')->count();

        // FORCE LA RÉCUPÉRATION : On s'assure d'embarquer la relation 'pharmacie'
        $commandesRecentes = Commande::with(['pharmacie'])
            ->orderByDesc('created_at')
            ->simplePaginate(5);

        return view('admin.dashboard', compact(
            'pharmacies', 'totalCommandes', 'commandesAujourdhui',
            'revenuTotal', 'revenuAujourdhui', 'totalPatients',
            'commandesRecentes'
        ));
    }
}
