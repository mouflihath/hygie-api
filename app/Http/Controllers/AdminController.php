<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;
use App\Models\Contact;
use App\Models\Pharmacie;

class AdminController extends Controller
{



// ── Utilisateurs ──
public function utilisateurs(Request $request)
{
    $role   = $request->get('role');
    $search = $request->get('search');

    $users = User::with('pharmacie')
        ->when($role,   fn($q) => $q->where('role', $role))
        ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                    ->orWhere('email', 'like', "%$search%"))
        ->latest()
        ->paginate(15);

    $stats = [
        'total'     => User::count(),
        'admins'    => User::where('role', 'admin')->count(),
        'pharmacies'=> User::where('role', 'pharmacie')->count(),
        'livreurs'  => User::where('role', 'livreur')->count(),
        'patients'  => User::where('role', 'patient')->count(),
    ];

    return view('admin.utilisateurs', compact('users', 'stats'));
}

public function destroyUser(User $user)
{
    $user->delete();
    return back()->with('success', 'Utilisateur supprimé.');
}

// ── Commandes ──
public function commandes(Request $request)
{
    $statut = $request->get('statut');
    $search = $request->get('search');

    $commandes = Commande::with(['pharmacie', 'patient'])
        ->when($statut, fn($q) => $q->where('statut', $statut))
            ->when($search, fn($q) => $q->where('reference_commande', 'like', "%$search%"))
            ->latest()
            ->paginate(20);

        $stats = [
            'total'        => Commande::count(),
            'en_attente'   => Commande::where('statut', 'en_attente')->count(),
            'livrees'      => Commande::where('statut', 'livree')->count(),
            'revenu_total' => Commande::sum('commission_application'),
        ];

        return view('admin.commandes', compact('commandes', 'stats'));
    }

    public function revenus(Request $request)
    {
    $periode = $request->get('periode', 'mois'); // jour / semaine / mois / annee

    $revenuTotal     = Commande::sum('commission_application');
    $revenuAujourdhui = Commande::whereDate('created_at', today())->sum('commission_application');
    $revenuSemaine   = Commande::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('commission_application');
    $revenuMois      = Commande::whereMonth('created_at', now()->month)->sum('commission_application');

    // Revenus par pharmacie
    $parPharmacie = Commande::with('pharmacie')
        ->selectRaw('pharmacie_id, SUM(commission_application) as total, COUNT(*) as nb_commandes')
        ->groupBy('pharmacie_id')
        ->orderByDesc('total')
        ->get();

    // Revenus par mois (12 derniers mois)
    $parMois = Commande::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mois, SUM(commission_application) as total")
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

    return view('admin.revenus', compact(
        'revenuTotal', 'revenuAujourdhui', 'revenuSemaine', 'revenuMois',
        'parPharmacie', 'parMois'
    ));
}

// ── Avis ──
public function avis(Request $request)
{
    $search = $request->get('search');

    $avis = Contact::when($search, fn($q) => $q->where('message', 'like', "%$search%")
                                    ->orWhere('nom', 'like', "%$search%"))
        ->latest()
        ->paginate(16);

    $stats = [
        'total'        => Contact::count(),
        'avec_sujet'   => Contact::whereNotNull('sujet')->where('sujet', '<>', '')->count(),
        'sans_sujet'   => Contact::whereNull('sujet')->orWhere('sujet', '')->count(),
        'cette_semaine'=> Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
    ];

    return view('admin.avis', compact('avis', 'stats'));
}
}
