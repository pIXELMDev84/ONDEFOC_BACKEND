<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BonJournalier;
use App\Models\Consommation;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;


class BonJournalierController extends Controller
{
    // Créer un bon journalier avec les produits retirés
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'produits' => 'required|array',
            'produits.*.produit_id' => 'required|exists:produits,id',
            'produits.*.quantite_retirer' => 'required|integer|min:1',
        ]);
    
        // Générer le prochain code (BJ#0001, BJ#0002...)
        $dernierBon = BonJournalier::latest()->first();
        $numero = $dernierBon ? intval(substr($dernierBon->code, 3)) + 1 : 1;
        $code = 'BJ#' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    
        // Créer le bon journalier
        $bonJournalier = BonJournalier::create([
            'date' => $request->date,
            'code' => $code,
        ]);
    
        // Gérer les retraits de stock
        foreach ($request->produits as $produitData) {
            $produit = Stock::where('produit_id', $produitData['produit_id'])->first();
    
            if (!$produit || $produit->quantite < $produitData['quantite_retirer']) {
                return response()->json(['error' => 'Stock insuffisant'], 400);
            }
    
            // Ajouter la consommation
            Consommation::create([
                'bon_journalier_id' => $bonJournalier->id,
                'produit_id' => $produitData['produit_id'],
                'quantite_retirer' => $produitData['quantite_retirer']
            ]);
    
            // Mettre à jour le stock
            $produit->quantite -= $produitData['quantite_retirer'];
            $produit->save();
        }
    
        return response()->json([
            'message' => 'Bon journalier créé avec succès',
            'bon_journalier' => $bonJournalier
        ]);
    }
    

    // Voir un bon journalier avec ses consommations (et télécharger le PDF)
    public function show($id)
    {
        $bonJournalier = BonJournalier::with('consommations.produit')->findOrFail($id);
    
        // Charger et convertir l'image en base64
        $imagePath = public_path('images/logo.png');
        if (file_exists($imagePath)) {
            $type = pathinfo($imagePath, PATHINFO_EXTENSION);
            $data = file_get_contents($imagePath);
            $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $base64Image = null; // Si l'image n'existe pas, éviter une erreur
        }
    
        // Générer le PDF avec l'image
        $pdf = PDF::loadView('bons.bon_journalier', compact('bonJournalier', 'base64Image'));
    
        return $pdf->download('bon_journalier_'.$bonJournalier->id.'.pdf');
    }
    

    public function index()
{
    $bonsJournaliers = BonJournalier::with('consommations.produit')->orderBy('created_at', 'desc')->get();
    return response()->json($bonsJournaliers);
}

    // Supprimer un bon journalier
    public function destroy($id)
    {
        $bonJournalier = BonJournalier::findOrFail($id);
        $bonJournalier->delete();

        return response()->json(['message' => 'Bon journalier supprimé avec succès']);
    }

    
}
