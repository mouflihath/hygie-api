<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // Importé pour la transaction
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // 🟢 INSCRIPTION PATIENT
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'surname'   => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'telephone' => 'required|string', // Requis pour créer le profil patient
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Utilisation d'une transaction : si le patient échoue, l'user n'est pas créé
            $result = DB::transaction(function () use ($request) {

                $user = User::create([
                    'name'     => $request->name,
                    'surname'  => $request->surname,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'patient', // On définit le rôle ici
                ]);

                $patient = Patient::create([
                    'user_id'   => $user->id,
                    'telephone' => $request->telephone,
                    'adresse'   => $request->adresse ?? 'Non précisée',
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                return [
                    'user'  => $user,
                    'token' => $token,
                    'tel'   => $patient->telephone
                ];
            });

            return response()->json([
                'message' => 'Inscription réussie',
                'token'   => $result['token'],
                'user'    => [
                    'name'    => $result['user']->name,
                    'surname' => $result['user']->surname,
                    'email'   => $result['user']->email,
                    'telephone' => $result['tel'],
                    'role'    => $result['user']->role,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du compte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔵 CONNEXION
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        // On charge la relation proprement (si définie dans le modèle User)
        // Sinon on garde ta méthode avec le point d'interrogation (Safe navigation)
        $patient = Patient::where('user_id', $user->id)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token'   => $token,
            'user'    => [
                'id'        => $user->id,
                'name'      => $user->name,
                'surname'   => $user->surname,
                'email'     => $user->email,
                'telephone' => $patient?->telephone,
                'role'      => $user->role,
            ]
        ]);
    }

    // 🔴 DECONNEXION
    public function logout(Request $request)
    {
        // Supprime le token actuel
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
