<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BonDeCommandeController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/bdcm/{id}/pdf', [BonDeCommandeController::class, 'telechargerPDF'])->name('bons.pdf');
Route::view('/login', 'login');
