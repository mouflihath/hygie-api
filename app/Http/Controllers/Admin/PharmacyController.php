<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pharmacie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PharmacyController extends Controller
{

/**
     * NOUVELLE MÉTHODE : Pour ton Frontend React
     * Retourne toutes les pharmacies validées en JSON
     */
    public function getPharmaciesForApi()
    {
        $pharmacies = Pharmacie::where('validee', true)->latest()->get();

        // On transforme les données pour que React reçoive des noms simples
        $data = $pharmacies->map(function ($pharma) {
            return [
                'id' => $pharma->id,
                'nom' => $pharma->nom_pharmacie, // On adapte au JS
                'adresse' => $pharma->adresse,
                'ville' => $pharma->ville,
                'telephone' => $pharma->telephone,
                'image' => $pharma->image, // Juste le chemin
                'est_ouvert' => true, // Tu pourras ajouter une vraie logique plus tard
            ];
        });

        return response()->json($data, 200);
    }
    /**
     * Affiche la liste des pharmacies.
     */
    public function index()
    {
        // On récupère les pharmacies avec l'utilisateur associé
        $pharmacies = Pharmacie::with('user')->latest()->get();
        return view('admin.pharmacies', compact('pharmacies'));
    }

    /**
     * Enregistre une nouvelle pharmacie et son compte utilisateur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ville' => 'required|string',
            'quartier' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Création du compte utilisateur (C'est lui qui gère la connexion)
            $user = User::create([
                'name' => $request->nom,
                'surname' => 'Pharmacie',
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hachage crucial
                'role' => 'pharmacie',
            ]);

            // 2. Gestion de l'image du logo
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('logos', 'public');
            }

            // 3. Création des détails dans la table pharmacies
            // On utilise la relation définie dans le modèle User
            $user->pharmacie()->create([
                'nom_pharmacie' => $request->nom,
                'adresse' => $request->quartier ?? 'Non précisée',
                'ville' => $request->ville,
                'telephone' => $request->telephone,
                'image' => $imagePath,
                'validee' => true,
            ]);
        });

        return redirect()->back()->with('success', 'La pharmacie a été enregistrée avec succès. Vous pouvez maintenant vous connecter avec cet email.');
    }

    /**
     * Retourne les données d'une pharmacie pour la modale Edit (via AJAX/JSON).
     */
    public function edit($id)
    {
        $pharmacie = Pharmacie::with('user')->findOrFail($id);

        return response()->json([
            'id' => $pharmacie->id,
            'nom' => $pharmacie->nom_pharmacie,
            'email' => $pharmacie->user->email,
            'telephone' => $pharmacie->telephone,
            'ville' => $pharmacie->ville,
            'adresse' => $pharmacie->adresse,
            'image' => $pharmacie->image ? asset('storage/' . $pharmacie->image) : null,
        ]);
    }

    /**
     * Met à jour les informations de la pharmacie et du compte.
     */
    public function update(Request $request, $id)
    {
        $pharmacie = Pharmacie::findOrFail($id);
        $user = $pharmacie->user;

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'required|string',
            'password' => 'nullable|min:6', // Password optionnel ici
            'image' => 'nullable|image|max:2048',
            'ville' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $pharmacie, $user) {
            // 1. Update de l'Utilisateur
            $user->name = $request->nom;
            $user->email = $request->email;

            // On ne change le mot de passe que s'il est saisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // 2. Update de la Pharmacie
            $data = [
                'nom_pharmacie' => $request->nom,
                'adresse' => $request->quartier,
                'ville' => $request->ville,
                'telephone' => $request->telephone,
            ];

            if ($request->hasFile('image')) {
                // Supprimer l'ancien logo si nouveau téléchargement
                if ($pharmacie->image) {
                    Storage::disk('public')->delete($pharmacie->image);
                }
                $data['image'] = $request->file('image')->store('logos', 'public');
            }

            $pharmacie->update($data);
        });

        return redirect()->back()->with('success', 'Informations de la pharmacie mises à jour.');
    }

    /**
     * Supprime la pharmacie et le compte utilisateur associé.
     */
    public function destroy($id)
    {
        $pharmacie = Pharmacie::findOrFail($id);

        DB::transaction(function () use ($pharmacie) {
            if ($pharmacie->image) {
                Storage::disk('public')->delete($pharmacie->image);
            }

            $user = $pharmacie->user;

            $pharmacie->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->back()->with('success', 'La pharmacie et son compte ont été supprimés.');
    }
}
