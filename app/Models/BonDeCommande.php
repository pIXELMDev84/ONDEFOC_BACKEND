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
        'date',

    ];



    // Relation avec le fournisseur
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function bonDecommande()
    {
        return $this->hasMany(BondDeCommandeProduit::class, 'bondecommande_id', 'id');
    }
}
