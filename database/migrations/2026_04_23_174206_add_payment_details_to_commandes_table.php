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
        // On ajoute toutes les colonnes qui manquent pour MediPresto
        $table->integer('montant_pharmacie')->nullable()->after('reference_commande');
        $table->integer('frais_livraison')->default(0)->after('montant_pharmacie');
      //  $table->integer('commission_application')->nullable()->after('frais_livraison');
        $table->integer('montant_total_patient')->nullable()->after('commission_application');
       $table->string('fedapay_transaction_id')->nullable()->after('montant_total_patient');
    });
}

public function down()
{
    Schema::table('commandes', function (Blueprint $table) {
        $table->dropColumn([
            'montant_pharmacie',
            'frais_livraison',
          //  'commission_application',
            'montant_total_patient',
            'fedapay_transaction_id'
        ]);
    });
}
};
