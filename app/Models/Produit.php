<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'code', 'tva', 'unite_mesure','categories_id'];

    public function category()
    {
        return $this->belongsTo(Categorie::class, 'categories_id');
    }

}
