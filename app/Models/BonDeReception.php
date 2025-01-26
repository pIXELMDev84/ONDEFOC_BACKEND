<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonDeReception extends Model
{
    protected $fillable = ['code', 'fournisseur_id', 'bon_commande_id', 'date', 'etat'];



    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id','id');
    }
    public function bonsDeReception()
    {
        return $this->hasMany(BonDeReceptionProduit::class,'bon_de_reception_id','id');
    }

    public function produit()
    {
        return $this->hasManyThrough(Produit::class, BonDeReceptionProduit::class, 'bon_de_reception_id','id','id','produit_id');
    }

    public function produits()
{
    return $this->hasManyThrough(Produit::class, BonDeReceptionProduit::class, 'bon_de_reception_id','id','id','produit_id');
}
public function bonDeCommande()
{
    return $this->belongsTo(BonDeCommande::class, 'bon_commande_id');
}

}
