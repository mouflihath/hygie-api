<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

   public function store(Request $request): RedirectResponse
{
    // 1. Nettoyage
    $request->merge(['custom_code' => strtoupper($request->custom_code)]);

    // 2. Validation
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'surname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'role' => ['required', 'string', 'in:pharmacie,livreur'],
        'custom_code' => ['required', 'string', 'unique:users,custom_code'],
        'telephone' => ['required', 'string', 'max:20'], // Sera envoyé dans la table spécifique
        'password' => ['required', 'confirmed', Rules\Password::defaults()],

        // Validation Pharmacie
        'nom_pharmacie' => [Rule::requiredIf($request->role === 'pharmacie'), 'nullable', 'string', 'max:255'],
        'adresse' => [Rule::requiredIf($request->role === 'pharmacie'), 'nullable', 'string', 'max:255'],
        'ville' => [Rule::requiredIf($request->role === 'pharmacie'), 'nullable', 'string', 'max:255'],

        // Validation Livreur
        'vehicule' => [Rule::requiredIf($request->role === 'livreur'), 'nullable', 'string', 'in:moto,velo,voiture'],
        'matricule' => [Rule::requiredIf($request->role === 'livreur'), 'nullable', 'string', 'max:50'],
    ]);

    $role = $request->role;
    $code = $request->custom_code;
    $role = $request->role;

    // --- LOGIQUE DE VÉRIFICATION (STRICTE) ---
    if ($role === 'pharmacie') {
        $number = (int) str_replace('PHARMA', '', $code);
        if (!str_starts_with($code, 'PHARMA') || $number < 900 || $number > 925) {
            return back()->withErrors(['custom_code' => 'Code Pharmacie invalide.'])->withInput();
        }
    }
    if ($role === 'livreur') {
        $number = (int) str_replace('LIV', '', $code);
        if (!str_starts_with($code, 'LIV') || $number < 400 || $number > 420) {
            return back()->withErrors(['custom_code' => 'Code Livreur invalide.'])->withInput();
        }
    }

    // --- CRÉATION UNIQUE (On ne passe pas par des relations ici) ---
    $user = User::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'role' => $role,
        'custom_code' => $request->custom_code,
        'password' => Hash::make($request->password),
        'validee' => false,
    ]);

    // --- ÉTAPE B : DISTRIBUTION DES INFOS DANS LES TABLES DÉDIÉES ---
    if ($role === 'pharmacie') {
        $user->pharmacie()->create([
            'telephone' => $request->telephone, // Le téléphone va ici !
            'nom_pharmacie' => $request->nom_pharmacie,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
        ]);
    }
    elseif ($role === 'livreur') {
        $user->livreur()->create([
            'telephone' => $request->telephone, // Le téléphone va ici !
            'vehicule' => $request->vehicule,
            'matricule' => $request->matricule,
            'statut' => 'disponible',
        ]);
    }

    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('dashboard');
}
}
