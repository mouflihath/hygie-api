<?php
namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Medicament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $pharmacieId = Auth::user()->pharmacie->id;
        $stocks = Stock::with('medicament')
            ->where('pharmacie_id', $pharmacieId)
            ->whereHas('medicament')
            ->get();
        $medicaments = Medicament::all(); // Pour le formulaire d'ajout

        return view('pharmacie.stocks.index', compact('stocks', 'medicaments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicament_id' => 'required',
            'quantite' => 'required|integer|min:0',
            'prix' => 'required|numeric|min:0',
        ]);

        Stock::updateOrCreate(
            [
                'pharmacie_id' => Auth::user()->pharmacie->id,
                'medicament_id' => $request->medicament_id
            ],
            [
                'quantite' => $request->quantite,
                'prix' => $request->prix
            ]
        );

        return back()->with('success', 'Stock mis à jour !');
    }

    public function destroy(Stock $stock)
    {
        // Sécurité : Vérifier que le stock appartient bien à cette pharmacie
        if($stock->pharmacie_id !== Auth::user()->pharmacie->id) abort(403);

        $stock->delete();
        return back()->with('success', 'Médicament retiré du stock.');
    }
}
