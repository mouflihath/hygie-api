<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::table('commandes', function (Blueprint $table) {
        // On retire le ->after() pour éviter l'erreur
        $table->decimal('commission_application', 10, 2)->default(0);
      
    });
}

public function down(): void
{
    Schema::table('commandes', function (Blueprint $table) {
        $table->dropColumn('commission_application');
    });
}
};
