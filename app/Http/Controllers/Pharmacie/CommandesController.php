<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandesController extends Controller
{
    public function index()
    {
        $pharmacieId = Auth::user()->pharmacie?->id ?? 0;

        $commandes = Commande::where('pharmacie_id', $pharmacieId)
            ->with(['lignes', 'patient'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pharmacie.commandes.index', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        $commande->load(['patient.patient', 'pharmacie']);

        $statutLabel = 'En attente';
        if (in_array($commande->statut, ['validée', 'validé', 'livree', 'livrée', 'livree'], true)) {
            $statutLabel = 'Livrée';
        } elseif ($commande->statut && $commande->statut !== 'en_attente') {
            $statutLabel = ucfirst(str_replace('_', ' ', $commande->statut));
        }

        return response()->json([
            'reference' => $commande->pharmacie_reference,
            'client_nom' => $commande->patient_nom
                ?? ($commande->patient ? trim($commande->patient->name . ' ' . $commande->patient->surname) : null)
                ?? 'N/A',
            'client_telephone' => $commande->patient_telephone
                ?? $commande->patient?->patient?->telephone
                ?? 'N/A',
            'adresse' => $commande->patient?->patient?->adresse ?? 'N/A',
            'pharmacie' => $commande->pharmacie?->nom_pharmacie
                ?? 'Pharmacie #' . ($commande->pharmacie_id ?? 'N/A'),
            'mode_livraison_label' => $commande->mode_livraison === 'livraison'
                ? '🚚 Livraison'
                : '🏪 Retrait',
            'statut' => $statutLabel,
            'montant_total' => number_format(
                $commande->montant_total_patient
                    ?? $commande->montant_total
                    ?? 0,
                0,
                ',',
                ' '
            ),
            'date' => optional($commande->created_at)->format('d M Y à H:i'),
        ]);
    }
}
