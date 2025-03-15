<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['produit_id', 'category_id', 'quantite'];



    public function categories()
    {
        return $this->belongsTo(Categorie::class,'category_id');
    }
    public function produit()

    {   
        return $this->belongsTo(Produit::class, 'produit_id');
    }

}


