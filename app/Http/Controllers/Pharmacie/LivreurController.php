<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livreur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LivreurController extends Controller
{
    public function index()
    {
        $pharmacieId = Auth::user()->pharmacie->id;

        // On récupère les livreurs avec leurs infos utilisateurs
        $livreurs = Livreur::with('user')
                    ->where('pharmacie_id', $pharmacieId)
                    ->get();

        return view('pharmacie.livreurs.index', compact('livreurs'));
    }

    public function store(Request $request)
    {
        // 1. AJOUT DU MATRICULE DANS LA VALIDATION
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'telephone' => 'required',
            'matricule' => 'required|string|max:50', // Obligatoire pour le chic !
            'vehicule' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            // Création de l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'surname' => 'Livreur',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'livreur',
            ]);

            // 2. AJOUT DU MATRICULE DANS LA CRÉATION DU LIVREUR
            Livreur::create([
                'user_id' => $user->id,
                'pharmacie_id' => Auth::user()->pharmacie->id,
                'telephone' => $request->telephone,
                'vehicule' => $request->vehicule,
                'matricule' => $request->matricule, // <--- C'était ça l'erreur !
                'statut' => 'disponible',
            ]);
        });

        return back()->with('success', 'Nouveau livreur enregistré avec succès !');
    }

    public function destroy($id)
    {
        $livreur = Livreur::findOrFail($id);

        // Sécurité : Vérifier que le livreur appartient bien à cette pharmacie
        if ($livreur->pharmacie_id === Auth::user()->pharmacie->id) {
            $user = $livreur->user;
            $livreur->delete();
            if ($user) $user->delete();

            return back()->with('success', 'Accès révoqué.');
        }

        return back()->with('error', 'Action non autorisée.');
    }
}
