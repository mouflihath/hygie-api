<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicamentController extends Controller
{
    public function rechercher(Request $request)
    {
        try {
            $query = $request->query('q');

            if (!$query || strlen($query) < 2) {
                return response()->json([]);
            }

            // 1. On sépare les mots par la virgule et on nettoie les espaces
            $motsCles = array_filter(array_map('trim', explode(',', $query)));

            $queryBuilder = DB::table('stocks')
                ->join('medicaments', 'stocks.medicament_id', '=', 'medicaments.id')
                ->join('pharmacies', 'stocks.pharmacie_id', '=', 'pharmacies.id')
                ->select(
                    'stocks.id',
                    'stocks.medicament_id',
                    'stocks.pharmacie_id',
                    'medicaments.nom as nom',
                    'stocks.prix',
                    'pharmacies.nom_pharmacie',
                    'pharmacies.adresse',
                    'pharmacies.ville',
                    'stocks.quantite'
                )
                ->where('stocks.quantite', '>', 0);

            // 2. On ajoute une condition pour chaque médicament demandé
            $queryBuilder->where(function($q) use ($motsCles) {
                foreach ($motsCles as $mot) {
                    $q->orWhere('medicaments.nom', 'LIKE', "%{$mot}%");
                }
            });

            $resultats = $queryBuilder->get();

            return response()->json($resultats);

        } catch (\Exception $e) {
            Log::error('Erreur recherche médicament : ' . $e->getMessage());

            return response()->json([
                'error' => 'Erreur de base de données',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
