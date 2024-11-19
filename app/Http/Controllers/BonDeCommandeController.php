<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BonDeCommande;

class BonDeCommandeController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données envoyées par le frontend
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'produit_name' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
            'tva' => 'required|numeric|min:0|max:100',
            'date' => 'required|date',
        ]);

        // Calcul du prix total avec TVA
        $prix_unitaire = $request->prix_unitaire;
        $quantite = $request->quantite;
        $tva = $request->tva;

        // Calcul du prix total (prix unitaire * quantité)
        $prix_total = ($prix_unitaire * $quantite) * (1 + $tva / 100);

        // Génération du code de bon de commande (par exemple #0001)
        $lastBonDeCommande = BonDeCommande::latest()->first();
        $nextCode = $lastBonDeCommande ? '#'.str_pad(substr($lastBonDeCommande->code, 1) + 1, 4, '0', STR_PAD_LEFT) : '#0001';

        // Création du bon de commande
        $bonDeCommande = BonDeCommande::create([
            'code' => $nextCode,
            'fournisseur_id' => $request->fournisseur_id,
            'produit_name' => $request->produit_name,
            'quantite' => $quantite,
            'prix_unitaire' => $prix_unitaire,
            'tva' => $tva,
            'prix_total' => $prix_total,
            'date' => $request->date,
        ]);

        return response()->json([
            'message' => 'Bon de commande créé avec succès',
            'bon_de_commande' => $bonDeCommande
        ], 201);
    }
}
