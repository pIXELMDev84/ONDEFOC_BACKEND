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
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->string('adresse')->nullable();  // Ajoute la colonne 'adresse'
        });
    }

    public function down()
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->dropColumn('adresse');  // Supprime la colonne 'adresse'
        });
    }
};
