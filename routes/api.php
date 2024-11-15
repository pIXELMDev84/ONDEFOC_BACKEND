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



Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
//enregistrement/login(login/register)
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::get('/users', [UserController::class, 'index']);
