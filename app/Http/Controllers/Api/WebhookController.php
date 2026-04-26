<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleFedaPay(Request $request)
{
    $transactionId = $request->query('id') ?? $request->input('id');
    $status        = $request->query('status') ?? $request->input('status');

    if ($transactionId && $status === 'approved') {
        $commande = Commande::where('fedapay_transaction_id', $transactionId)->first();
        if ($commande) {
            $commande->update([
                'statut_paiement' => 'payé',
                'statut'   => $commande->mode_livraison === 'livraison' ? 'en_attente' : 'pret_retrait'
            ]);
        }
    }

    return response()->json(['status' => 'ok']);
}
}
