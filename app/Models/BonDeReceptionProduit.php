<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonDeReceptionProduit extends Model
{
    protected $fillable = [
        'bon_de_reception_id',
        'produit_id',
        'quantite_recu',
        'prix_unitaire',
        'prix_total',
        'tva',
        'unite'
    ];

    public function produit()
    {
        return $this->hasOne(Produit::class, 'produit_id', 'id');
    }
}
