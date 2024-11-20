<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            $table->decimal('total_ht', 15, 2)->after('prix_total')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            $table->dropColumn('total_ht');
        });
    }
};
