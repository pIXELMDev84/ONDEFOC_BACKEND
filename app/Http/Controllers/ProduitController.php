<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'tva' => 'required|numeric|min:0|max:100',
            'unite_mesure' => 'required|string|max:50',
            'categories_id' => 'required|exists:categories,id',

        ]);

        // Ajout du code produit automatiquement
        $validated['code'] = $this->generateUniqueCode();

        return Produit::create($validated);
    }

    private function generateUniqueCode()
    {
        $prefix = '#SKP';
        $latestProduct = Produit::latest('id')->first();

        // Générer le numéro en fonction du dernier ID
        $number = $latestProduct ? $latestProduct->id + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getProduits()
    {
        $produits = Produit::all(); // Récupère tous les produits
        return response()->json($produits); // Renvoie les produits sous forme de JSON
    }

    public function show($id)
    {
        return Produit::findOrFail($id);
    }

    public function index()
    {
        return Produit::all();
    }
    
    public function getProduitsParCategorie($categorieId)
    {
        $produits = Produit::where('categories_id', $categorieId)->get();
    
        if ($produits->isEmpty()) {
            return response()->json(['message' => 'Aucun produit trouvé'], 404);
        }
    
        return response()->json($produits);
    }
}

