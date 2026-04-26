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
    Schema::table('livreurs', function (Blueprint $table) {
        // On ajoute la clé étrangère vers la table pharmacies
        $table->foreignId('pharmacie_id')->after('user_id')->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('livreurs', function (Blueprint $table) {
        $table->dropForeign(['pharmacie_id']);
        $table->dropColumn('pharmacie_id');
    });
}
};
