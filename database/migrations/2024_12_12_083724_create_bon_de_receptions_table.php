<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bon_de_receptions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('bon_commande_id');
            $table->date('date');
            $table->string('etat')->default('en_attente');
            $table->timestamps();
    
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->foreign('bon_commande_id')->references('id')->on('bon_de_commandes')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bon_de_receptions');
    }
};
