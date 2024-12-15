<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BondDeCommandeProduit extends Model
{


    protected $fillable =[
        'bdc_id',
        'produit_name',
        'quantite',
        'prix_unitaire',
        'tva',
        'prix_total',
        'unite'
    ];
}
