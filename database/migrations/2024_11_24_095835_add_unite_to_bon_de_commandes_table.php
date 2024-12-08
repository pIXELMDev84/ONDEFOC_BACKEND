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

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            $table->dropColumn('unite'); // Supprime la colonne si rollback
        });
    }
};
