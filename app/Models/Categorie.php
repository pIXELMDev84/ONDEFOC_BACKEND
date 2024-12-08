<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
