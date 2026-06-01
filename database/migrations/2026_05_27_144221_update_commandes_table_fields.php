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
            // On ajoute les nouveaux champs s'ils n'existent pas encore
            if (!Schema::hasColumn('commandes', 'reference_commande')) {
                $table->string('reference_commande')->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('commandes', 'montant_pharmacie')) {
                $table->integer('montant_pharmacie')->default(0)->after('montant_total');
            }
            if (!Schema::hasColumn('commandes', 'frais_livraison')) {
                $table->integer('frais_livraison')->default(0)->after('montant_pharmacie');
            }
            if (!Schema::hasColumn('commandes', 'commission_application')) {
                $table->integer('commission_application')->default(0)->after('frais_livraison');
            }
            if (!Schema::hasColumn('commandes', 'montant_total_patient')) {
                $table->integer('montant_total_patient')->default(0)->after('commission_application');
            }
            if (!Schema::hasColumn('commandes', 'mode_livraison')) {
                $table->string('mode_livraison')->default('retrait')->after('statut');
            }
            if (!Schema::hasColumn('commandes', 'methode_paiement')) {
                $table->string('methode_paiement')->default('fedapay')->after('mode_livraison');
            }
            if (!Schema::hasColumn('commandes', 'etat_commande')) {
                $table->string('etat_commande')->default('en_attente')->after('statut');
            }
            if (!Schema::hasColumn('commandes', 'message_client')) {
                $table->text('message_client')->nullable()->after('etat_commande');
            }
            if (!Schema::hasColumn('commandes', 'patient_nom')) {
                $table->string('patient_nom')->nullable()->after('patient_id');
            }
            if (!Schema::hasColumn('commandes', 'patient_telephone')) {
                $table->string('patient_telephone')->nullable()->after('patient_nom');
            }
            if (!Schema::hasColumn('commandes', 'fedapay_transaction_id')) {
                $table->string('fedapay_transaction_id')->nullable()->after('methode_paiement');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn([
                'reference_commande', 'montant_pharmacie', 'frais_livraison', 
                'commission_application', 'montant_total_patient', 'mode_livraison',
                'methode_paiement', 'etat_commande', 'message_client', 
                'patient_nom', 'patient_telephone', 'fedapay_transaction_id'
            ]);
        });
    }
};