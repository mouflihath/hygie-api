<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RevenusController extends Controller
{
    public function index()
    {
        // ── Récupère la pharmacie connectée ──────────────────────────────────
        // On suppose que l'utilisateur connecté a une relation pharmacie
        $pharmacieId = auth()->user()->pharmacie->id;

        // ── Revenus totaux ────────────────────────────────────────────────────
        $base = Commande::where('pharmacie_id', $pharmacieId);

        $revenuTotal = (clone $base)->sum('commission_application');

        // ── Aujourd'hui ───────────────────────────────────────────────────────
        $revenuAujourdhui = (clone $base)
            ->whereDate('created_at', Carbon::today())
            ->sum('commission_application');

        // ── Cette semaine (lundi → dimanche) ─────────────────────────────────
        $revenuSemaine = (clone $base)
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->sum('commission_application');

        // ── Ce mois ───────────────────────────────────────────────────────────
        $revenuMois = (clone $base)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('commission_application');

        // ── Évolution sur les 12 derniers mois ────────────────────────────────
        $parMois = (clone $base)
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mois"),
                DB::raw('SUM(commission_application) as total')
            )
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // ── Commandes récentes de cette pharmacie (10 dernières) ──────────────
        $commandesRecentes = Commande::where('pharmacie_id', $pharmacieId)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('pharmacie.revenus', compact(
            'revenuTotal',
            'revenuAujourdhui',
            'revenuSemaine',
            'revenuMois',
            'parMois',
            'commandesRecentes'
        ));
    }
}
