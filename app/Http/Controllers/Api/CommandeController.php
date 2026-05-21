<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

            $patientId = Auth::id();
            if (!$patientId) {
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
            }

            $clientName = trim(($request->client_nom ?? $request->name ?? '') . ' ' . ($request->client_prenom ?? $request->surname ?? ''));
            $clientName = $clientName ?: ($request->client_nom ?? $request->name ?? $request->client_prenom ?? $request->surname ?? 'Client');
            $clientEmail = $request->client_email ?? $request->email ?? $request->clientEmail ?? $request->email_client ?? null;
            $clientPhone = $request->client_tel ?? $request->client_telephone ?? $request->telephone ?? $request->phone ?? null;

            if (!$patientId) {
                $patientUser = null;
                if ($clientEmail) {
                    $patientUser = User::where('email', $clientEmail)
                        ->where('role', 'patient')
                        ->first();
                }

                if (!$patientUser) {
                    $generatedEmail = $clientEmail;
                    if (!$generatedEmail || User::where('email', $generatedEmail)->exists()) {
                        $generatedEmail = 'guest+' . Str::random(16) . '@hygieplus.local';
                    }

                    [$firstName, $lastName] = array_pad(explode(' ', $clientName, 2), 2, 'Client');

                    $patientUser = User::create([
                        'name'     => $firstName ?: 'Client',
                        'surname'  => $lastName ?: 'Client',
                        'email'    => $generatedEmail,
                        'password' => Hash::make(Str::random(24)),
                        'role'     => 'patient',
                    ]);

                    Patient::create([
                        'user_id'   => $patientUser->id,
                        'telephone' => $clientPhone,
                        'adresse'   => $request->adresse ?? 'Non précisée',
                    ]);
                }

                $patientId = $patientUser->id;
            }

            $commande = Commande::create([
                'pharmacie_id'           => $request->pharmacie_id ?? 1,
                'patient_id'             => $patientId,
                'reference_commande'     => $request->reference_commande,
                'montant_pharmacie'      => $request->montant_pharmacie,
                'commission_application' => $request->commission_application,
                'montant_total_patient'  => (int) round($request->montant_total_patient),
                'montant_total'          => (int) round($request->montant_total_patient),
                'mode_livraison'         => $request->mode_livraison,
                'fedapay_transaction_id' => $transaction->id,
                'statut_paiement'        => 'en_attente',
                'statut'                 => 'en_attente',
            ]);

            if ($request->has('medicaments') && is_array($request->medicaments)) {
                foreach ($request->medicaments as $med) {
                    LigneCommande::create([
                        'commande_id'   => $commande->id,
                        'medicament_id' => $med['id'] ?? null,
                        'nom'           => $med['nom'] ?? $med['name'] ?? 'Médicament',
                        'quantite'      => $med['qte'] ?? 1,
                        'prix'          => $med['prix'] ?? 0,
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

    /**
     * Retourne uniquement le statut d'une commande.
     * GET /api/commandes/{id}/statut
     */
    public function getStatut($id)
    {
        $commande = Commande::findOrFail($id);

        return response()->json([
            'statut' => $commande->statut,
        ]);
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|string|in:en_attente,en_preparation,en_livraison,a_retirer,livree'
        ]);

        $commande = Commande::findOrFail($id);
        $newStatut = $request->statut;
        $commande->update([
            'etat_commande' => $newStatut,
            'statut'        => $newStatut,
        ]);

        return response()->json(['success' => true, 'commande' => $commande]);
    }
}
