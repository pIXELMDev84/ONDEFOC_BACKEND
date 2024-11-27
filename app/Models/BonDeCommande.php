<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeCommande extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'fournisseur_id',
        'produit_name',
        'quantite',
        'prix_unitaire',
        'tva',
        'prix_total',
        'date',
        'unite'
    ];

    // Relation avec le fournisseur
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function createdBy()
{
    return $this->belongsTo(User::class, 'created_by');
}
}
