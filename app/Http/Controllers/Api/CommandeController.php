<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        \FedaPay\FedaPay::setApiKey('sk_sandbox_zxcOxe9DYEWX8_qKziuveaAj');
        \FedaPay\FedaPay::setEnvironment('sandbox');
        \FedaPay\FedaPay::setVerifySslCerts(false);

        Log::info('Hygie+ - Nouvelle commande', [
            'reference'    => $request->reference_commande,
            'montant'      => (int) round($request->montant_total_patient),
            'client'       => $request->client_nom,
            'email'        => $request->client_email,
            'pharmacie_id' => $request->pharmacie_id,
        ]);

        try {
            $transaction = \FedaPay\Transaction::create([
                'description'  => 'Commande Hygie+ - ' . ($request->reference_commande ?? 'REF-TMP'),
                'amount'       => (int) round($request->montant_total_patient),
                'currency'     => ['iso' => 'XOF'],
                'callback_url' => 'http://localhost:3000/paiement-succes',
                'customer'     => [
                    'firstname' => $request->client_nom ?? 'Client',
                    'lastname'  => $request->client_prenom ?? 'Hygieplus',
                    'email'     => $request->client_email ?? 'client@hygieplus.bj',
                ],
            ]);

            Log::info('Transaction FedaPay créée', ['id' => $transaction->id]);

            $token = $transaction->generateToken();

            // ✅ Récupère l'utilisateur connecté si disponible
            $patientId = null;
            $token_auth = $request->header('Authorization');
            if ($token_auth) {
                $tokenValue = str_replace('Bearer ', '', $token_auth);
                $personalToken = DB::table('personal_access_tokens')
                    ->where('token', hash('sha256', $tokenValue))
                    ->first();
                if ($personalToken) {
                    $patientId = $personalToken->tokenable_id;
                }
            }

            // ✅ Crée la commande avec pharmacie_id correct
            $commande = Commande::create([
                'pharmacie_id'           => $request->pharmacie_id ?? 1,
                'patient_id'             => $patientId ?? 1,
                'reference_commande'     => $request->reference_commande,
                'montant_pharmacie'      => $request->montant_pharmacie,
                'commission_application' => $request->commission_application,
                'montant_total_patient'  => (int) round($request->montant_total_patient),
                'montant_total'          => (int) round($request->montant_total_patient),
                'mode_livraison'         => $request->mode_livraison,
                'fedapay_transaction_id' => $transaction->id,
                'statut_paiement'        => 'en_attente',
                'statut'                 => 'en_attente',
               // 'etat_commande'          => 'en_attente',
                //'patient_nom'            => $request->client_nom,
               // 'patient_telephone'      => $request->client_tel,
            ]);

            // ✅ Enregistre les lignes de commande (médicaments)
            if ($request->has('medicaments') && is_array($request->medicaments)) {
                foreach ($request->medicaments as $med) {
                    LigneCommande::create([
                        'commande_id' => $commande->id,
                        'medicament_id' => $med['id'] ?? null,
                        'nom'         => $med['nom'] ?? $med['name'] ?? 'Médicament',
                        'quantite'    => $med['qte'] ?? 1,
                        'prix'        => $med['prix'] ?? 0,
                    ]);
                }
            }

            Log::info('Commande enregistrée', [
                'commande_id'  => $commande->id,
                'pharmacie_id' => $commande->pharmacie_id,
                'fedapay_id'   => $transaction->id,
            ]);

            return response()->json([
                'success'            => true,
                'payment_url'        => $token->url,
                'reference_commande' => $request->reference_commande,
                'commande_id'        => $commande->id,
                'montant'            => (int) round($request->montant_total_patient),
                'mode_livraison'     => $request->mode_livraison,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur FedaPay', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function commandesPharmacie($id)
    {
        $commandes = Commande::where('pharmacie_id', $id)
            ->with('lignes')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($commandes);
    }

    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->update(['etat_commande' => $request->statut]);
        return response()->json(['success' => true, 'commande' => $commande]);
    }
}
