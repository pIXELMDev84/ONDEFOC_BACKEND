<?php

namespace App\Http\Controllers;
use App\Models\Fournisseur;
use App\Models\Categorie;

use Illuminate\Http\Request;

class FournisseurController extends Controller
{

    public function getCategories()
{
    $categories = Categorie::all();
    return response()->json($categories);
}
     // Récupérer tous les fournisseurs
     public function index()
     {
         $fournisseurs = Fournisseur::with('categorie')->get();
         return response()->json($fournisseurs);
     }

     // Créer un nouveau fournisseur
     public function store(Request $request)
     {
         // Validation des données
         $validated = $request->validate([
             'nom' => 'required|string|max:255',
             'prenom' => 'required|string|max:255',
             'email' => 'required|email|unique:fournisseurs,email',
             'num_telephone' => 'required|string',
             'categorie_id' => 'required|exists:categories,id',
         ]);

         // Création du fournisseur
         $fournisseur = Fournisseur::create($validated);

         return response()->json($fournisseur, 201);
     }

     // Modifier un fournisseur existant
     public function update(Request $request, Fournisseur $fournisseur)
     {
         $request->validate([
             'categorie_id' => 'required|exists:categories,id',
             'nom' => 'required|string',
             'prenom' => 'required|string',
             'num_telephone' => 'required|string',
             'email' => 'required|email|unique:fournisseurs,email,' . $fournisseur->id,
         ]);

         $fournisseur->update($request->all());
         return response()->json($fournisseur);
     }

     // Supprimer un fournisseur
     public function destroy(Fournisseur $fournisseur)
     {
         $fournisseur->delete();
         return response()->json(null, 204);
     }
}
