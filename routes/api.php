<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\BonDeCommandeController;
use App\Http\Controllers\BonDeReceptionController;




Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
//enregistrement/login(login/register)
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::get('/users', [UserController::class, 'index']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
//fournissuer
Route::get('/fournisseurs', [FournisseurController::class, 'index']);
Route::post('/fournisseurs/register', [FournisseurController::class, 'store']);
Route::put('/fournisseurs/{fournisseur}', [FournisseurController::class, 'update']);
Route::delete('/fournisseurs/{fournisseur}', [FournisseurController::class, 'destroy']);
//Bon De Commande
Route::post('/bdcm', [BonDeCommandeController::class, 'store']);
Route::delete('/supr/bdcm/{id}', [BonDeCommandeController::class, 'destroy']);
Route::get('/abdcm', [BonDeCommandeController::class, 'index']);
Route::put('/bdcm/{id}/etat', [BonDeCommandeController::class, 'updateEtat']);
Route::get('/bdcm/{id}/pdf', [BonDeCommandeController::class, 'telechargerPDF'])->name('bons.pdf');
//categories
Route::get('/categories', [FournisseurController::class, 'getCategories']);
//produit
Route::post('/produits/add', [ProduitController::class, 'store']);
Route::get('produits', [ProduitController::class, 'getProduits']);
//Bon De Reseption
Route::get('/abdrs', [BonDeReceptionController::class, 'index']);
Route::post('/bdrs', [BonDeReceptionController::class, 'store']);
Route::get('/bdrs/{id}/pdf', [BonDeReceptionController::class, 'telechargerPDF']);
Route::delete('/supr/bdrs/{id}', [BonDeReceptionController::class, 'destroy']);


