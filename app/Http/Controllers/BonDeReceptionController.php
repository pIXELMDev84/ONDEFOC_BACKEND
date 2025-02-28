<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BondDeCommandeProduit;
use App\Models\BonDeCommande;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\BonDeReception;
use App\Models\BonDeReceptionProduit;
use Barryvdh\DomPDF\Facade\Pdf;

class BonDeReceptionController extends Controller
{
    public function index()
    {
        // Récupérer tous les bons de réception avec les informations du fournisseur
        $bonsDeReception = BonDeReception::with('fournisseur', 'produits')->get();
        return response()->json($bonsDeReception);
    }

    public function store(Request $request)
    {

        // Validation des données
        $validated = $request->validate([
            'bon_commande_id' => 'required|exists:bon_de_commandes,id',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'produits' => 'required|array|min:1',
            'produits.*.produit_id' => 'required|exists:bond_de_commande_produits,id',
            'produits.*.quantite_recu' => 'required|integer|min:1'
        ]);

        $bondecommande = BonDeCommande::with('fournisseur', 'bonDecommande')->findOrFail($request->bon_commande_id);


        // Génération du code du bon de réception
        $lastBonDeReception = BonDeReception::latest()->first();
        $nextCode = $lastBonDeReception ? '#BR' . str_pad(substr($lastBonDeReception->code, 3) + 1, 4, '0', STR_PAD_LEFT) : '#BR0001';

        // Création du bon de réception
        $bonDeReception = BonDeReception::create([
            'code' => $nextCode,
            'bon_commande_id' => $validated['bon_commande_id'],
            'fournisseur_id' => $validated['fournisseur_id'],
            'date' => now(),
        ]);

        // Ajout des produits au bon de réception
        foreach ($validated['produits'] as $produit) {



            $produitexiste = BondDeCommandeProduit::findOrFail($produit['produit_id']);


            if($produitexiste->bondecommande_id == $bondecommande->id){
                $prixtotal = $produitexiste->prix_unitaire * $produit['quantite_recu'];
                $idproduit = Produit::where('nom',$produitexiste->produit_name)->first('id');
                $idpr = $idproduit->id;

                BonDeReceptionProduit::create([
                    'bon_de_reception_id' => $bonDeReception->id,
                    'produit_id' => $idpr,
                    'quantite_recu' => $produit['quantite_recu'],
                    'unite' => $produitexiste->unite,
                    'prix_unitaire' => $produitexiste->prix_unitaire,
                    'tva' => $produitexiste->tva,
                    'prix_total'=>$prixtotal
                ]);
            }
            else{
                return response()->json([
                    'error' => 'un des produit selectioner n`existe pas dans la base de donne',
                ], 404);
            }

        }

        return response()->json([
            'message' => 'Bon de réception créé avec succès',
            'bon_de_reception' => $nextCode,
        ], 201);
    }

    public function telechargerPDF($id)
    {
        $imagePath = public_path('images/logo.png');

        // Récupérer le bon de réception par son ID
        $bon = BonDeReception::with('fournisseur', 'bonsDeReception', 'bonDeCommande')->findOrFail($id);
        // return response()->json(
        //     [
        //             'm'=>$bon
        //     ]
        //     );
        foreach ($bon->bonsDeReception as $bond) {
            $produitInfo = Produit::findOrFail($bond->produit_id);
            $bond->produit = $produitInfo->nom;
        }


        // return response()->json(
        //     [
        //             'm'=>$bon
        //     ]
        //     );
        $total_quantite = $bon->bonsDeReception->sum('quantite_recu');

        $imageData = base64_encode(file_get_contents($imagePath));
        $base64Image = 'data:image/png;base64,' . $imageData;

        // Charger la vue PDF
        $pdf = Pdf::loadView('bons.bdrspdf', [
            'bonInfo' => $bon,
            'produits' => $bon->bonsDeReception,
            'fournisseur' => $bon->fournisseur,
            'total_quantite' => $total_quantite,
            'base64Image' => $base64Image,
            'bon_commande_code' => $bon->bonDeCommande->code,
        ]);

        // Télécharger le fichier PDF
        return $pdf->download("Bon_de_reception_{$bon->id}.pdf");
    }

    public function destroy($id)
    {
        // Récupérer le bon de réception
        $bonDeReception = BonDeReception::find($id);

        if (!$bonDeReception) {
            return response()->json(['message' => 'Bon de réception introuvable'], 404);
        }

        // Supprimer le bon de réception
        $bonDeReception->delete();

        return response()->json(['message' => 'Bon de réception supprimé avec succès'], 200);
    }
}
