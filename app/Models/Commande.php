<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commande extends Model
{
    use HasFactory;

    // 1. Autoriser l'insertion de ces champs (Indispensable pour le $request->all())
    protected $fillable = [
        'patient_id',
        'pharmacie_id',
        'livreur_id',
        'statut',
        'mode_livraison',
        'montant_total'
    ];

    // 2. Relations mises à jour avec les bonnes clés étrangères de ta migration

    public function patient(): BelongsTo
    {
        // On précise 'patient_id' car ce n'est pas le nom par défaut (user_id)
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function pharmacie(): BelongsTo
    {
        // Si tes pharmacies sont aussi dans la table Users, utilise User::class
        return $this->belongsTo(User::class, 'pharmacie_id');
    }

    public function livreur(): BelongsTo
    {
        // nullable dans ta migration, donc peut renvoyer null
        return $this->belongsTo(User::class, 'livreur_id');
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }
}
