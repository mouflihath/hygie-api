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
        $table->string('patient_nom')->nullable()->after('patient_id');
        $table->string('patient_telephone')->nullable()->after('patient_nom');
    });
}

public function down(): void
{
    Schema::table('commandes', function (Blueprint $table) {
        $table->dropColumn(['patient_nom', 'patient_telephone']);
    });
}
};
