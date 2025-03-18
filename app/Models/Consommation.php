<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consommation extends Model
{
    use HasFactory;
    
    protected $fillable = ['bon_journalier_id', 'produit_id', 'quantite_retirer'];

    public function bonJournalier()
    {
        return $this->belongsTo(BonJournalier::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
    
}
