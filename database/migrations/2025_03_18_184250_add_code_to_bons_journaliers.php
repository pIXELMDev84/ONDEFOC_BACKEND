<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('bons_journaliers', function (Blueprint $table) {
            $table->string('code')->unique()->after('id');
        });
    }

    public function down() {
        Schema::table('bons_journaliers', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
