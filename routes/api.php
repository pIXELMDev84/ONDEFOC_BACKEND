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
Route::get('/bdcm/{id}/pdf', [BonDeCommandeController::class, 'telechargerPDF'])->name('bons.pdf');

