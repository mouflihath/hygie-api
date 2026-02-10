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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pharmacie_id')->constrained()->onDelete('cascade');
            $table->foreignId('livreur_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('statut', ['en_attente', 'confirmee', 'en_preparation', 'en_livraison', 'livree']);
            $table->enum('mode_livraison', ['retrait', 'livraison_pharmacie', 'livraison_hygie']);
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
