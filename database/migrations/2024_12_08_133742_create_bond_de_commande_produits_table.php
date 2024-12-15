<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('bond_de_commande_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bondecommande_id')->constrained('bon_de_commandes','id')->onDelete('cascade');
            $table->string('produit_name');  // Le nom du produit
            $table->integer('quantite');  // La quantité
            $table->decimal('prix_unitaire', 10, 2);  // Le prix unitaire
            $table->string('etat')->default('en_attente');
            $table->decimal('tva', 5, 2);  // TVA en pourcentage
            $table->decimal('prix_total', 10, 2);  // Prix total (prix unitaire * quantité + TVA)
            $table->string('unite'); // Ajoute la colonne après 'produit_name'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bond_de_commande_produits');
    }
};
