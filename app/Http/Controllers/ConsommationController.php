<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consommation;
use App\Models\Stock;

class ConsommationController extends Controller
{
    // Ajouter une consommation et mettre à jour le stock
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite_retirer' => 'required|integer|min:1',
        ]);

        $produit = Stock::where('produit_id', $request->produit_id)->first();

        if (!$produit || $produit->quantite < $request->quantite_retirer) {
            return response()->json(['error' => 'Quantité insuffisante en stock'], 400);
        }

        // Ajouter la consommation
        Consommation::create([
            'produit_id' => $request->produit_id,
            'quantite_retirer' => $request->quantite_retirer
        ]);

        // Mettre à jour le stock
        $produit->quantite -= $request->quantite_retirer;
        $produit->save();

        return response()->json(['message' => 'Produit retiré avec succès']);
    }

    // Lister toutes les consommations
    public function index()
    {
        $consommations = Consommation::with('produit')->get();
        return response()->json($consommations);
    }
}
