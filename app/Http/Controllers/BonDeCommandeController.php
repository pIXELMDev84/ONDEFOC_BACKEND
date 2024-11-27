<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BonDeCommande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;



class BonDeCommandeController extends Controller
{


    public function index()
    {
    // Récupérer tous les bons de commande avec les informations du fournisseur
      $bonsDeCommande = BonDeCommande::with('fournisseur', 'createdBy')->get();

      return response()->json($bonsDeCommande);
    }

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
            'unite' => 'nullable|string',
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
            'unite' => $request->unite,
            'created_by' => Auth::id(),

        ]);

        return response()->json([
            'message' => 'Bon de commande créé avec succès',
            'bon_de_commande' => $bonDeCommande
        ], 201);
    }



    public function updateEtat(Request $request, $id)
{
    // Valider l'état envoyé
    $request->validate([
        'etat' => 'required|in:en_attente,validé',
    ]);

    // Récupérer le bon de commande
    $bonDeCommande = BonDeCommande::findOrFail($id);

    // Mettre à jour l'état
    $bonDeCommande->etat = $request->etat;
    $bonDeCommande->save();

    return response()->json([
        'message' => 'L\'état du bon de commande a été mis à jour.',
        'bon_de_commande' => $bonDeCommande
    ]);
}


public function telechargerPDF($id)
{
    // Récupérer le bon de commande par son ID
    $bon = BonDeCommande::with('fournisseur')->findOrFail($id);

    // Recalculer les valeurs nécessaires
    $quantite = $bon->quantite;
    $prix_unitaire = $bon->prix_unitaire;
    $tva = $bon->tva;

    $total_ht = $quantite * $prix_unitaire; // Total hors taxe
    $total_tva = ($tva / 100) * $total_ht; // Montant de la TVA
    $total_ttc = $total_ht + $total_tva; // Total TTC

    // Charger une vue pour le PDF avec les totaux calculés
    $pdf = Pdf::loadView('bons.pdf', [
        'bon' => $bon,
        'total_ht' => $total_ht,
        'total_tva' => $total_tva,
        'total_ttc' => $total_ttc,
    ]);

    // Télécharger le fichier PDF
    return $pdf->download("Bon_de_commande_{$bon->id}.pdf");
}

    public function destroy($id)
{
    // Récupérer le bon de commande par son ID
    $bonDeCommande = BonDeCommande::find($id);

    // Vérifier si le bon de commande existe
    if (!$bonDeCommande) {
        return response()->json([
            'message' => 'Bon de commande introuvable'
        ], 404);
    }

    // Supprimer le bon de commande
    $bonDeCommande->delete();

    return response()->json([
        'message' => 'Bon de commande supprimé avec succès'
    ], 200);
}
}
