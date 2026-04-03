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
        Schema::create('pharmacies', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('nom_pharmacie');
    $table->string('adresse');
    $table->string('ville');
    $table->string('telephone');

    // Ajout de la colonne pour l'image (logo)
    // nullable() permet d'enregistrer une pharmacie même si elle n'a pas encore de logo
    $table->string('image')->nullable();

    $table->boolean('validee')->default(false);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
