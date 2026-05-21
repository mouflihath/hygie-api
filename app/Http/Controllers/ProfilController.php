<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // ── Mise à jour nom / email ───────────────────────────────────────────
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // ── Suppression de la photo ───────────────────────────────────────────
        if ($request->boolean('supprimer_photo') && $user->photo_profil) {
            Storage::disk('public')->delete($user->photo_profil);
            $user->photo_profil = null;
        }

        // ── Upload nouvelle photo ─────────────────────────────────────────────
        if ($request->hasFile('photo_profil')) {
            // Supprimer l'ancienne si elle existe
            if ($user->photo_profil) {
                Storage::disk('public')->delete($user->photo_profil);
            }

            $path = $request->file('photo_profil')->store('photos-profil', 'public');
            $user->photo_profil = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Supprimer la photo avant de supprimer le compte
        if ($user->photo_profil) {
            Storage::disk('public')->delete($user->photo_profil);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
