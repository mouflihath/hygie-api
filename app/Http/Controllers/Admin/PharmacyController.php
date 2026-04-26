<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pharmacie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{
    public function index()
    {
        $pharmacies = Pharmacie::with('user')->latest()->get();
        return view('admin.pharmacies', compact('pharmacies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_pharmacie' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string',
            'password' => 'required|min:6',
            'image' => 'nullable|image|max:5120',
            'ville' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nom_pharmacie,
                'surname' => 'Pharmacie',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pharmacie',
                'email_verified_at' => now(),
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('logos', 'public');
            }

            $user->pharmacie()->create([
                'nom_pharmacie' => $request->nom_pharmacie,
                'adresse' => $request->adresse ?? 'Non précisée',
                'ville' => $request->ville,
                'telephone' => $request->telephone,
                'image' => $imagePath,
                'validee' => true,
            ]);
        });

        return redirect()->back()->with('success', 'Établissement enregistré avec succès.');
    }

    public function update(Request $request, $id)
    {
        $pharmacie = Pharmacie::findOrFail($id);
        $user = $pharmacie->user;

        $request->validate([
            'nom_pharmacie' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'required|string',
            'ville' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $pharmacie, $user) {
            // Update User
            $user->update([
                'name' => $request->nom_pharmacie,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            // Update Pharmacie
            $data = [
                'nom_pharmacie' => $request->nom_pharmacie,
                'adresse' => $request->adresse,
                'ville' => $request->ville,
                'telephone' => $request->telephone,
            ];

            if ($request->hasFile('image')) {
                if ($pharmacie->image) {
                    Storage::disk('public')->delete($pharmacie->image);
                }
                $data['image'] = $request->file('image')->store('logos', 'public');
            }

            $pharmacie->update($data);
        });

        return redirect()->back()->with('success', 'Informations mises à jour.');
    }

    public function destroy($id)
    {
        $pharmacie = Pharmacie::findOrFail($id);
        DB::transaction(function () use ($pharmacie) {
            if ($pharmacie->image) {
                Storage::disk('public')->delete($pharmacie->image);
            }
            $user = $pharmacie->user;
            $pharmacie->delete();
            if ($user) $user->delete();
        });

        return redirect()->back()->with('success', 'Partenaire supprimé.');
    }

    // Cette méthode servira à ton Front-end React
public function getPharmaciesForApi()
{
    // On récupère les pharmacies validées avec les infos de l'utilisateur lié
    $pharmacies = Pharmacie::where('validee', true)->with('user')->latest()->get();

    return response()->json($pharmacies, 200);
}
}
