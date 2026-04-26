<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OrdonnanceController extends Controller
{
    public function analyser(Request $request)
    {
        try {
            // 1. Validation du fichier
            if (!$request->hasFile('ordonnance')) {
                return response()->json(['success' => false, 'message' => 'Aucun fichier reçu.'], 400);
            }

            $file = $request->file('ordonnance');
            $extension = strtolower($file->getClientOriginalExtension());
            $path = $file->getPathname();
            $texteBrut = "";

            // 2. Extraction du texte (PDF ou Image)
            if ($extension === 'pdf') {
                try {
                    $parser = new Parser();
                    $pdf = $parser->parseFile($path);
                    $texteBrut = $pdf->getText();
                } catch (\Exception $e) {
                    $texteBrut = ""; // Si échec PDF, on peut tenter l'OCR en dessous
                }
            }

            // Si texte toujours vide (Image ou PDF scanné)
            if (empty(trim($texteBrut))) {
                $tesseractPath = 'C:\Program Files\Tesseract-OCR\tesseract.exe';
                if (file_exists($tesseractPath)) {
                    $ocr = new TesseractOCR($path);
                    $ocr->executable($tesseractPath);
                    $texteBrut = $ocr->lang('fra')->psm(6)->run();
                }
            }

            // 3. Normalisation du texte pour la recherche
            $texteAnalyse = $this->normaliser($texteBrut);

            // 4. Recherche des médicaments dans la table 'stocks'
            $medicaments = Medicament::all();
            $resultatsFinal = [];

            foreach ($medicaments as $med) {
                $nomMedBase = $this->normaliser($med->nom);

                // Si le nom du médicament est présent dans le texte de l'ordonnance
                if (str_contains($texteAnalyse, $nomMedBase)) {

                    // On cherche les prix dans la table 'stocks'
                    $offres = DB::table('stocks')
                        ->join('pharmacies', 'pharmacies.id', '=', 'stocks.pharmacie_id')
                        ->where('stocks.medicament_id', $med->id)
                        ->where('stocks.quantite', '>', 0) // Uniquement ceux en stock
                        ->select(
                                'pharmacies.id as pharmacie_id', // ← AJOUTE ÇA
                                'pharmacies.nom_pharmacie',
                                'pharmacies.adresse',
                                'pharmacies.ville',
                                'stocks.prix',
                                'stocks.quantite'
                            )
                        ->orderBy('stocks.prix', 'asc')
                        ->get();

                    if ($offres->isNotEmpty()) {
                        $resultatsFinal[] = [
                            'medicament_identifie' => $med->nom,
                            'offres' => $offres
                        ];
                    }
                }
            }

            // 5. Réponse finale
            return response()->json([
                'success' => count($resultatsFinal) > 0,
                'data' => $resultatsFinal,
                'debug_ia' => $texteBrut // Pour voir ce que l'IA a lu
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur Analyse : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur technique lors de l’analyse',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nettoie le texte (minuscule, sans accents) pour faciliter la comparaison
     */
    private function normaliser($str) {
        $str = mb_strtolower($str, 'UTF-8');
        $str = str_replace(
            ['é', 'è', 'ê', 'ë', 'à', 'â', 'î', 'ï', 'ô', 'û', 'ù', 'ç'],
            ['e', 'e', 'e', 'e', 'a', 'a', 'i', 'i', 'o', 'u', 'u', 'c'],
            $str
        );
        // On ne garde que les lettres et chiffres pour éviter les problèmes de ponctuation
        return preg_replace('/[^a-z0-9]/', ' ', $str);
    }
}
