<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'categorie_id',
        'nom',
        'prenom',
        'num_telephone',
        'email',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}