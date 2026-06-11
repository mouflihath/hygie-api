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

    protected $fillable = [
        // Champs originaux
        'patient_id',
        'pharmacie_id',
        'livreur_id',
        'statut',
        'mode_livraison',
        'montant_total',

        // Nouveaux champs envoyés depuis React
        'reference_commande',
        'montant_pharmacie',
        'frais_livraison',
        'commission_application',
        'montant_total_patient',
        'methode_paiement',
        'etat_commande',
        'message_client',
        'patient_nom',
        'patient_telephone',
        'fedapay_transaction_id',

    ];

    // ── RELATIONS ────────────────────────────────────────────────────────────

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function pharmacie(): BelongsTo
    {
        return $this->belongsTo(Pharmacie::class, 'pharmacie_id');
    }

    public function livreur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'livreur_id');
    }

    // Lignes de commande (médicaments commandés)
    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    // Alias plus explicite pour les médicaments de la commande
    public function medicaments(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPharmacieReferenceAttribute(): string
    {
        if (! $this->pharmacie_id || ! $this->created_at) {
            return $this->reference_commande
                ? ('#CMD-' . preg_replace('/^#?CMD-?/i', '', $this->reference_commande))
                : ('#CMD-' . ($this->id ?? '0'));
        }

        $count = static::where('pharmacie_id', $this->pharmacie_id)
            ->where(function ($query) {
                $query->where('created_at', '<', $this->created_at)
                    ->orWhere(function ($query2) {
                        $query2->where('created_at', $this->created_at)
                            ->where('id', '<=', $this->id);
                    });
            })
            ->count();

        return '#CMD-' . $count;
    }
}
