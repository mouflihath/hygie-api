<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandesController extends Controller
{
    public function index()
    {
        $pharmacieId = Auth::user()->pharmacie?->id ?? 0;

        $commandes = Commande::where('pharmacie_id', $pharmacieId)
            ->with(['lignes', 'patient'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pharmacie.commandes.index', compact('commandes'));
    }
}
