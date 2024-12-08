<?php

namespace App\Http\Controllers;

use App\Models\BondDeCommandeProduit;
use Illuminate\Http\Request;
use App\Models\BonDeCommande;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BonDeCommandeController extends Controller
{
    public function index()
    {
    // Récupérer tous les bons de commande avec les informations du fournisseur
      $bonsDeCommande = BonDeCommande::with('fournisseur')->get();

      return response()->json($bonsDeCommande);
    }

    public function store(Request $request)
    {
        // Validation des données envoyées par le frontend
        $validated=$request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'produits' => 'required|array|min:1',
            'produits.*.name' =>'required|string|min:1',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
            'produits.*.tva' => 'required|numeric|min:0|max:100',
            'produits.*.unite' =>'required|string|min:1',
            'date' => 'required|date',
        ]);

        // Calcul du prix total avec TVA
        $prix_unitaire = $request->prix_unitaire;
        $quantite = $request->quantite;
        $tva = $request->tva;

        // Calcul du prix total (prix unitaire * quantité

        // Génération du code de bon de commande (par exemple #0001)
        $lastBonDeCommande = BonDeCommande::latest()->first();
        $nextCode = $lastBonDeCommande ? '#'.str_pad(substr($lastBonDeCommande->code, 1) + 1, 4, '0', STR_PAD_LEFT) : '#0001';

        $bondecommadeId = BonDeCommande::create([
            'code' => $nextCode,
            'fournisseur_id' => $validated['fournisseur_id']


        ]);
        // Création du bon de commande
            foreach($validated['produits'] as $produit)
            {
                $produitdb = new BondDeCommandeProduit();
                $produitdb->bondecommande_id=$bondecommadeId->id;
                $produitdb->produit_name = $produit['name'];
                $produitdb->quantite = $produit['quantite'];
                $produitdb->prix_unitaire = $produit['prix_unitaire'];
                $produitdb->tva = $produit['tva'];
                $produitdb->unite = $produit['unite'];
                $produitdb->prix_total = ($produit['prix_unitaire'] * $produit['quantite']) * (1 + $produit['tva']/ 100);
                $produitdb->save();
            }

        return response()->json([
            'message' => 'Bon de commande créé avec succès',
            'bon_de_commande' => $nextCode
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

    $imagePath = public_path('images/logo.png');
    // Récupérer le bon de commande par son ID
    $bon = BonDeCommande::with('fournisseur', 'bondecommande')->findOrFail($id);


    // Recalculer les valeurs nécessaires
    // $quantite = $bon->quantite;
    // $prix_unitaire = $bon->prix_unitaire;
    // $tva = $bon->tva;
    $total_ht=0;
    $total_tva=0;
    $total_ttc=0;
    foreach($bon->bondecommande as $commande)
    {
        $total_ht_unite = $commande['quantite'] * $commande['prix_unitaire'] ;
        $total_ht+=$commande['quantite'] * $commande['prix_unitaire'] ;
        $total_tva+=($commande['tva'] /100) * $total_ht_unite;
    }

    // $total_ht = $quantite * $prix_unitaire; // Total hors taxe
    // $total_tva = ($tva / 100) * $total_ht; // Montant de la TVA
    $total_ttc = $total_ht + $total_tva; // Total TTC

    $imageData = base64_encode(file_get_contents($imagePath));
        $base64Image = 'data:image/png;base64,' . $imageData;

    // Charger une vue pour le PDF avec les totaux calculés
    $pdf = Pdf::loadView('bons.pdf', [
        'bonInfo'=>$bon,
        'bon' => $bon->bondecommande,
        'fournisseur' => $bon->fournisseur,
        'total_ht' => $total_ht,
        'total_tva' => $total_tva,
        'total_ttc' => $total_ttc,
        'base64Image' => $base64Image
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
$path =public_path().'/logo.png';
//$type =pathinfo($path,PATHINFO_EXTENSION);
//$data =file_get_contents($path);
//$image ='data:image/'.$type.';base64'.base64_encode($data);
