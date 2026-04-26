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
    Schema::create('expeditions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pharmacie_id')->constrained()->onDelete('cascade');
        $table->foreignId('livreur_id')->nullable()->constrained()->onDelete('set null');
        $table->string('nom_client');
        $table->string('adresse_livraison');
        $table->enum('status', ['en_attente', 'en_route', 'livree'])->default('en_attente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expeditions');
    }
};
