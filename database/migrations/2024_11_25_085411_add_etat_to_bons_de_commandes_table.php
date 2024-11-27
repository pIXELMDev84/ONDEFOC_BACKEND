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
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            // Ajout de la colonne 'etat' après 'produit_name' avec la valeur par défaut 'en_attente'
            $table->string('etat')->default('en_attente')->after('produit_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            // Suppression de la colonne 'etat'
            $table->dropColumn('etat');
        });
    }

};
