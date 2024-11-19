<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bon_de_commandes', function (Blueprint $table) {
            $table->id();
            $table->string('code');  // Le code du bon de commande (par exemple, #0001)
            $table->foreignId('fournisseur_id')->constrained('fournisseurs');  // ID du fournisseur
            $table->string('produit_name');  // Le nom du produit
            $table->integer('quantite');  // La quantité
            $table->decimal('prix_unitaire', 10, 2);  // Le prix unitaire
            $table->decimal('tva', 5, 2);  // TVA en pourcentage
            $table->decimal('prix_total', 10, 2);  // Prix total (prix unitaire * quantité + TVA)
            $table->date('date');  // La date de la commande
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bon_de_commandes');
    }
};
