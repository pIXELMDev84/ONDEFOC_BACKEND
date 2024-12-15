<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bon_de_reception_produits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bon_de_reception_id');
            $table->unsignedBigInteger('produit_id');
            $table->integer('quantite_recu');
            $table->string('unite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->float('tva');
            $table->decimal('prix_total', 10, 2);
            $table->timestamps();
    
            $table->foreign('bon_de_reception_id')->references('id')->on('bon_de_receptions')->onDelete('cascade');
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bon_de_reception_produits');
    }
};
