<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FournisseurController extends Controller
{
     // Récupérer tous les fournisseurs
     public function index()
     {
         $fournisseurs = Fournisseur::with('categorie')->get();
         return response()->json($fournisseurs);
     }
 
     // Créer un nouveau fournisseur
     public function store(Request $request)
     {
         $request->validate([
             'categorie_id' => 'required|exists:categories,id',
             'nom' => 'required|string',
             'prenom' => 'required|string',
             'num_telephone' => 'required|string',
             'email' => 'required|email|unique:fournisseurs,email',
         ]);
 
         $fournisseur = Fournisseur::create($request->all());
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