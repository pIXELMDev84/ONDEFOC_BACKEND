<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonJournalier extends Model
{
    use HasFactory;

    protected $table = 'bons_journaliers';

    protected $fillable = ['date', 'code'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'consommations')
            ->withPivot('quantite')
            ->withTimestamps();
    }
    public function consommations()
{
    return $this->hasMany(Consommation::class);
}
}
