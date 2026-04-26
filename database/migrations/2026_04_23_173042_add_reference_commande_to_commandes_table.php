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
    Schema::table('commandes', function (Blueprint $table) {
        // On ajoute la colonne qui manque
        $table->string('reference_commande')->after('id')->nullable();
    });
}

public function down()
{
    Schema::table('commandes', function (Blueprint $table) {
        $table->dropColumn('reference_commande');
    });
}
};
